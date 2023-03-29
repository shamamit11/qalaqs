<?php
namespace App\Services\Api\User;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Tax;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrderService
{ 
    public function processPayment($request) {
        try {
            $card_name = $request['card_name'];
            $card_number = $request['card_number'];
            $expiry_month = $request['expiry_month'];
            $expiry_year = $request['expiry_year'];
            $cvc = $request['cvc'];
            $total_amount = $request['total_amount'];
           
            //Payment API

            $payment_status = 'success';

            if($payment_status == 'success') {
                $response['message'] = 'Payment Successful !';
                $response['transaction_id'] = 'e768378c-ce7e-11ed-afa1-0242ac120002';
                $response['errors'] = false;
                $response['status_code'] = 201;
                return response()->json($response, 201);
            } 
            else {
                $response['message'] = 'There is an error processing your card !!';
                $response['errors'] = true;
                $response['status_code'] = 401;
                return response()->json($response, 401);
            }
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function createOrder($request) { 
        try {
            $user_id = Auth::guard('user-api')->id();
            $cart_session_id = $request['cart_session_id'];
            $shipping_address_id = $request['shipping_address_id'];
            $shipping_charge = $request['shipping_charge'];
            $transaction_id = $request['transaction_id'];

            $cartData = Cart::where([['user_id', $user_id], ['session_id', $cart_session_id]])->first();
            $item_count = $cartData->item_count;
            $promo_code = $cartData->promo_code;
            $promo_type = $cartData->promo_type;
            $promo_value = $cartData->promo_value;
            $sub_total = $cartData->sub_total;

            if($promo_type) {
                switch($promo_type) {
                    case 'P':
                        $promo_discount = $sub_total * $promo_value / 100;
                        break;
                    case 'A':
                        $promo_discount = $sub_total - $promo_value;
                        break;
                    default:
                        $promo_discount = 0.00;
                }
            }

            $tax = Tax::findOrFail(1);
            $tax_amount = $sub_total * $tax->percentage / 100;

            $grand_total = $sub_total - $promo_discount + $tax_amount + $shipping_charge;

            $shippingAddress = UserAddress::where([['id', $shipping_address_id], ['user_id', $user_id]])->first();
            
            $order_id = generateOrderID();

            $orderData = new Order;
            $orderData->order_id = $order_id;
            $orderData->user_id = $user_id;
            $orderData->item_count = $item_count;
            $orderData->vat_percentage = $tax->percentage;
            $orderData->vat_amount = $tax_amount;
            $orderData->promo_code = $promo_code;
            $orderData->promo_type = $promo_type;
            $orderData->promo_value = $promo_value;
            $orderData->sub_total = $sub_total;
            $orderData->tax_total = $tax_amount;
            $orderData->grand_total = $grand_total;
            $orderData->delivery_charge = $shipping_charge;
            $orderData->delivery_name = $shippingAddress->name;
            $orderData->delivery_address = $shippingAddress->building. ', ' .$shippingAddress->street_name;
            $orderData->delivery_city = $shippingAddress->city;
            $orderData->delivery_country = $shippingAddress->country;
            $orderData->delivery_zip = '';
            $orderData->delivery_phone = $shippingAddress->mobile;
            $orderData->billing_name = $shippingAddress->name;
            $orderData->billing_address = $shippingAddress->building. ', ' .$shippingAddress->street_name;
            $orderData->billing_city = $shippingAddress->city;
            $orderData->billing_country = $shippingAddress->country;
            $orderData->billing_zip = '';
            $orderData->billing_phone = $shippingAddress->mobile;
            $orderData->order_note = '';
            $orderData->cancel_reason_id = '';
            $orderData->cancel_note = '';
            $orderData->payment_method = 'CC';
            $orderData->payment_transaction_id = $transaction_id;
            $orderData->save();

            $cartItems = CartItem::where('cart_session_id', $cart_session_id)->get();

            foreach($cartItems as $item) {
                $product = Product::where('id', $item->product_id)->first();
                $orderItem = new OrderItem;
                $orderItem->order_id = $order_id;
                $orderItem->product_id = $item->product_id;
                $orderItem->item_count = $item->item_count;
                $orderItem->amount = $product->price;
                $orderItem->sub_total = $item->sub_total;
                $orderItem->delivery_distance = '';
                $orderItem->delivery_charge = '';
                $orderItem->cod_charge = '';
                $orderItem->vendor_id = $item->vendor_id;
                $orderItem->order_status_id = 1;
                $orderItem->save();
            }

            //delete items from cart and cart_items
            Cart::where('session_id', $cart_session_id)->delete();
            CartItem::where('cart_session_id', $cart_session_id)->delete();

            $response['message'] = 'Order Placed Successfully !';
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);

        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function listOrders() {
        try {
            $user_id = Auth::guard('user-api')->id();
            $orders = Order::where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
            foreach($orders as $order) {
                $order->created_at = date("d/m/Y", strtotime($order->created_at));
            }
            $response['data'] = $orders;
            $response['errors'] = false;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function getOrderDetails($order_id) {
        try {
            $user_id = Auth::guard('user-api')->id();
            $order = Order::where([['user_id', $user_id], ['order_id', $order_id]])->first();

            $order_items = [];
            $orderItems = DB::table('order_items')
                ->leftJoin('products', 'products.id', '=', 'order_items.product_id')
                ->select('order_items.id as order_item_id', 'order_items.order_id','order_items.product_id', 'order_items.item_count as qty', 'order_items.sub_total', 'products.part_type', 'products.market', 'products.title', 'products.main_image')
                ->where('order_items.order_id', $order_id)
                ->get();
            // foreach($orders as $order) {
            //     $order->created_at = date("d/m/Y", strtotime($order->created_at));
            // }
            // $response['data'] = $orders;
            // $response['errors'] = false;
            // $response['status_code'] = 200;
            // return response()->json($response, 200);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}