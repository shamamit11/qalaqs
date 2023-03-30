<?php
namespace App\Services\Api\User;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\OrderReturn;
use App\Models\Product;
use App\Models\Tax;
use App\Models\UserAddress;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
                $response['message'] = 'success';
                $response['transaction_id'] = 'e768378c-ce7e-11ed-afa1-0242ac120002';
                $response['errors'] = false;
                $response['status_code'] = 201;
                return response()->json($response, 201);
            } 
            else {
                $response['message'] = 'error';
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
            $orderData->delivery_zip = '00000';
            $orderData->delivery_phone = $shippingAddress->mobile;
            $orderData->billing_name = $shippingAddress->name;
            $orderData->billing_address = $shippingAddress->building. ', ' .$shippingAddress->street_name;
            $orderData->billing_city = $shippingAddress->city;
            $orderData->billing_country = $shippingAddress->country;
            $orderData->billing_zip = '00000';
            $orderData->billing_phone = $shippingAddress->mobile;
            $orderData->order_note = '';
            $orderData->cancel_reason_id = 0;
            $orderData->cancel_note = '';
            $orderData->payment_method = 'CC';
            $orderData->payment_transaction_id = $transaction_id;
            $orderData->save();

            $cartItems = CartItem::where('cart_session_id', $cart_session_id)->get();

            foreach($cartItems as $item) {
                $product = Product::where('id', $item->product_id)->first();
                $orderItem = new OrderItem;
                $orderItem->order_id = $orderData->id;
                $orderItem->product_id = $item->product_id;
                $orderItem->item_count = $item->item_count;
                $orderItem->amount = $product->price;
                $orderItem->sub_total = $item->sub_total;
                $orderItem->delivery_distance = 0.0;
                $orderItem->delivery_charge = 0.00;
                $orderItem->cod_charge = 0.00;
                $orderItem->vendor_id = $item->vendor_id;
                $orderItem->order_status_id = 1;
                $orderItem->save();
            }

            //delete items from cart and cart_items
            Cart::where('session_id', $cart_session_id)->delete();
            CartItem::where('cart_session_id', $cart_session_id)->delete();

            $response['message'] = 'success';
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
                $order->order_date = date("d M Y", strtotime($order->created_at));
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
           
            $order = Order::where([['user_id', $user_id], ['id', $order_id]])->first(
                ['id', 'order_id', 'item_count','promo_type', 'promo_value', 'sub_total', 'vat_percentage', 'vat_amount', 'delivery_charge', 'grand_total', 'created_at', 'delivery_name', 'delivery_address', 'delivery_city', 'delivery_country', 'delivery_phone']
            );
            $order->order_date =  date("d M Y", strtotime($order->created_at));

            if($order->promo_type) {
                switch($order->promo_type) {
                    case 'P':
                        $promo_discount = $order->sub_total * $order->promo_value / 100;
                        break;
                    case 'A':
                        $promo_discount = $order->sub_total - $order->promo_value;
                        break;
                    default:
                        $promo_discount = 0.00;
                }
            }
            $order->promo_discount =  $promo_discount;

            $order_items = [];
            $orderItems = DB::table('order_items')
                ->leftJoin('products', 'products.id', '=', 'order_items.product_id')
                ->leftJoin('order_statuses', 'order_statuses.id', '=', 'order_items.order_status_id')
                ->select('order_items.id as order_item_id', 'order_items.order_id','order_items.product_id', 'order_items.item_count as qty', 'order_items.sub_total', 'order_items.updated_at', 'products.part_type', 'products.market', 'products.title', 'products.main_image', 'order_statuses.name as order_status_name')
                ->where('order_items.order_id', $order_id)
                ->get();

            foreach($orderItems as $item) {
                if($item->main_image) {
                    $item->main_image = env('APP_URL').'/storage/product/'.$item->main_image;
                    $item->updated_at = date("d M Y", strtotime($item->updated_at));
                }
            }
            $order_items['order'] = $order;
            $order_items['order_items'] = $orderItems;
       
            $response['data'] = $order_items;
            $response['errors'] = false;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function recentOrders() {
        try {
            $user_id = Auth::guard('user-api')->id();
            $date = Carbon::today()->subDays(7);
    
            $orderItems = DB::table('order_items')
                ->leftJoin('orders', 'orders.id', '=', 'order_items.order_id')
                ->leftJoin('products', 'products.id', '=', 'order_items.product_id')
                ->leftJoin('order_statuses', 'order_statuses.id', '=', 'order_items.order_status_id')
                ->select('order_items.*', 'products.title', 'products.main_image', 'order_statuses.name as order_status')
                ->where([['orders.user_id', $user_id], ['orders.created_at','>=', $date]])
                ->orderBy('order_items.created_at', 'desc')
                ->get();
    
            foreach($orderItems as $item) {
                $item->main_image = env('APP_URL').'/storage/product/'.$item->main_image;
                $item->created_at = date("d M Y", strtotime($item->created_at));
                $item->updated_at = date("d M Y", strtotime($item->updated_at));
            }

            $response['data'] = $orderItems;
            $response['errors'] = false;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } 
        catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function recentOrderDetail($id) {
        try {
            $orderItem = DB::table('order_items')
                ->leftJoin('products', 'products.id', '=', 'order_items.product_id')
                ->leftJoin('order_statuses', 'order_statuses.id', '=', 'order_items.order_status_id')
                ->select('order_items.*', 'products.title', 'products.main_image', 'order_statuses.name as order_status')
                ->where('order_items.id', $id)
                ->first();

            $orderItem->main_image = env('APP_URL').'/storage/product/'.$orderItem->main_image;
            $orderItem->created_at = date("d M Y", strtotime($orderItem->created_at));
            $orderItem->updated_at = date("d M Y", strtotime($orderItem->updated_at));

            $response['data'] = $orderItem;
            $response['errors'] = false;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        }
        catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function createOrderReturns($request) {
        try {
            $user_id = Auth::guard('user-api')->id();
            $orderReturn = new OrderReturn;
            $orderReturn->order_id = $request['order_id'];
            $orderReturn->order_item_id = $request['order_item_id'];
            $orderReturn->product_id = $request['product_id'];
            $orderReturn->user_id = $user_id;
            $orderReturn->vendor_id = $request['vendor_id'];
            $orderReturn->reason = $request['reason'];
            $orderReturn->status = 1;
            $orderReturn->save();

            $orderItem = OrderItem::where('id', $request['order_item_id'])->first();
            $orderItem->order_status_id = 7;
            $orderItem->save();

            $response['message'] = 'success';
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        }
        catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}