<?php
namespace App\Services\Api\User;

use App\Models\ItemStatusUpdate;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\OrderReturn;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\Tax;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Vendor;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Zepson\Dpo\Dpo;

class OrderService
{
    public function generatePaymentToken($request)
    {
        try {

            $user_id = Auth::guard('user-api')->id();
            $userData = User::where('id', $user_id)->first();

            $shipping_address_id = $request['shipping_address_id'];
            $shippingAddress = UserAddress::where([['id', $shipping_address_id], ['user_id', $user_id]])->first();

            $user = explode(" ", $shippingAddress->name);
            $date_now = Carbon::now();

            $endpoint = "https://secure.3gdirectpay.com/API/v6/";

            $xmlData = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
                <API3G>
                    <CompanyToken>" . env('DPO_COMPANY_TOKEN') . "</CompanyToken>
                    <Request>createToken</Request>
                    <Transaction>
                        <PaymentAmount>" . $request['total_amount'] . "</PaymentAmount>
                        <PaymentCurrency>AED</PaymentCurrency>
                        <CompanyRef>KDIEOM</CompanyRef>
                        <CompanyRefUnique>0</CompanyRefUnique>
                        <PTL>5</PTL>
                    </Transaction>
                    <customerEmail>" . $userData->email . "</customerEmail>
                    <customerFirstName>" . $user[0] . "</customerFirstName>
                    <customerLastName>" . $user[1] . "</customerLastName>
                    <customerCity>" . $shippingAddress->city . "</customerCity>
                    <customerCountry>" . $shippingAddress->country . "</customerCountry>
                    <customerAddress>" . $shippingAddress->country . "</customerAddress>
                    <customerPhone>" . $shippingAddress->mobile . "</customerPhone>
                    <Services>
                        <Service>
                            <ServiceType>48565</ServiceType>
                            <ServiceDescription>Items Purchase</ServiceDescription>
                            <ServiceDate>" . $date_now . "</ServiceDate>
                        </Service>
                    </Services>
                </API3G>";

            $ch = curl_init();

            if (!$ch) {
                die("Couldn't initialize a cURL handle");
            }
            curl_setopt($ch, CURLOPT_URL, $endpoint);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlData);

            $result = curl_exec($ch);
            curl_close($ch);

            $xml_res = simplexml_load_string($result, "SimpleXMLElement", LIBXML_NOCDATA);
            $xml_json = json_encode($xml_res);
            $xml_array = json_decode($xml_json, TRUE);

            $response['message'] = 'success';
            $response['token'] = $xml_array['TransToken'];
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);

        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function processPayment($request)
    {
        try {
            $endpoint = "https://secure.3gdirectpay.com/API/v6/";

            $xmlData = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
                <API3G>
                    <CompanyToken>" . env('DPO_COMPANY_TOKEN') . "</CompanyToken>
                    <Request>chargeTokenCreditCard</Request>
                    <TransactionToken>" . $request['transaction_token'] . "</TransactionToken>
                    <CreditCardNumber>" . $request['card_number'] . "</CreditCardNumber>
                    <CreditCardExpiry>" . $request['card_expiry'] . "</CreditCardExpiry>
                    <CreditCardCVV>" . $request['card_cvv'] . "</CreditCardCVV>
                    <CardHolderName>" . $request['card_name'] . "</CardHolderName>
                    <ChargeType></ChargeType>
                </API3G>";

            $ch = curl_init();

            if (!$ch) {
                die("Couldn't initialize a cURL handle");
            }
            curl_setopt($ch, CURLOPT_URL, $endpoint);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlData);

            $result = curl_exec($ch);
            curl_close($ch);

            $xml_res = simplexml_load_string($result, "SimpleXMLElement", LIBXML_NOCDATA);
            $xml_json = json_encode($xml_res);
            $xml_array = json_decode($xml_json, TRUE);

            if ($xml_array['Result'] == '999') {
                $response['message'] = $xml_array['ResultExplanation'];
                $response['errors'] = true;
                $response['status_code'] = 999;
                return response()->json($response, 999);
            } 
            
            if ($xml_array['Result'] == '902') {
                $response['message'] = $xml_array['ResultExplanation'];
                $response['errors'] = true;
                $response['status_code'] = 406;
                return response()->json($response, 406);
            } 
            
            if ($xml_array['Result'] == '200') {
                $response['message'] = $xml_array['ResultExplanation'];
                $response['errors'] = true;
                $response['status_code'] = 208;
                return response()->json($response, 208);
            } 
            
            if ($xml_array['Result'] == '000') {
                $data = array(
                    "cart_session_id" => $request['cart_session_id'],
                    "shipping_address_id" => $request['shipping_address_id'],
                    "shipping_charge" => $request['shipping_charge'],
                    "transaction_id" => $request['transaction_token']
                );

                $createOrder = $this->createOrder($data);
                return $createOrder;

                // $response['message'] = $xml_array['ResultExplanation'];
                // $response['errors'] = false;
                // $response['status_code'] = 200;
                // return response()->json($response, 200);
            }

        } 
        catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function createOrder($request)
    {
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

            $promo_discount = 0.00;

            if ($promo_type) {
                switch ($promo_type) {
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
            $orderData->delivery_address = $shippingAddress->building . ', ' . $shippingAddress->street_name;
            $orderData->delivery_city = $shippingAddress->city;
            $orderData->delivery_country = $shippingAddress->country;
            $orderData->delivery_zip = '00000';
            $orderData->delivery_phone = $shippingAddress->mobile;
            $orderData->billing_name = $shippingAddress->name;
            $orderData->billing_address = $shippingAddress->building . ', ' . $shippingAddress->street_name;
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

            foreach ($cartItems as $item) {
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
                $orderItem->save();

                //update item_status_updates table
                $statusUpdates = new ItemStatusUpdate;
                $statusUpdates->order_id = $orderData->id;
                $statusUpdates->order_item_id = $orderItem->id;
                $statusUpdates->user_id = $user_id;
                $statusUpdates->vendor_id = $item->vendor_id;
                $statusUpdates->status_id = 1;
                $statusUpdates->updated_by = 'system';
                $statusUpdates->save();

                //update notification table
                $vendorData = Vendor::where('id', $item->vendor_id)->first();
                $notification = new Notification;
                $notification->date = date("d M Y");
                $notification->device_id = $vendorData->device_id;
                $notification->receiver_id = $item->vendor_id;
                $notification->receiver_type = 'V';
                $notification->title = "New Order Request";
                $notification->message = "You have received New Order Request for - " . $product->title;
                $notification->status = 0;
                $notification->save();
            }

            //delete items from cart and cart_items
            Cart::where('session_id', $cart_session_id)->delete();
            CartItem::where('cart_session_id', $cart_session_id)->delete();

            $response['message'] = 'Order Placed Successfully !!';
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);
    }

    public function listOrders()
    {
        try {
            $user_id = Auth::guard('user-api')->id();
            $orders = Order::where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
            foreach ($orders as $order) {
                $order->order_date = date("d M Y", strtotime($order->created_at));
            }
            $response['data'] = $orders;
            $response['errors'] = false;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function getOrderDetails($order_id)
    {
        try {
            $user_id = Auth::guard('user-api')->id();

            $order = Order::where([['user_id', $user_id], ['id', $order_id]])->first(
                ['id', 'order_id', 'item_count', 'promo_type', 'promo_value', 'sub_total', 'vat_percentage', 'vat_amount', 'delivery_charge', 'grand_total', 'created_at', 'delivery_name', 'delivery_address', 'delivery_city', 'delivery_country', 'delivery_phone']
            );
            $order->order_date = date("d M Y", strtotime($order->created_at));

            $promo_discount = 0.00;

            if ($order->promo_type) {
                switch ($order->promo_type) {
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
            $order->promo_discount = $promo_discount;

            $order_items = [];
            $orderItems = DB::table('order_items')
                ->leftJoin('products', 'products.id', '=', 'order_items.product_id')
                ->select('order_items.id as order_item_id', 'order_items.order_id', 'order_items.product_id', 'order_items.item_count as qty', 'order_items.sub_total', 'order_items.updated_at', 'products.part_type', 'products.market', 'products.title', 'products.main_image')
                ->where('order_items.order_id', $order_id)
                ->get();

            foreach ($orderItems as $item) {
                if ($item->main_image) {
                    $item->main_image = env('APP_URL') . '/storage/product/' . $item->main_image;
                    $item->updated_at = date("d M Y", strtotime($item->updated_at));
                }
                $statusUpdate = ItemStatusUpdate::where('order_item_id', $item->order_item_id)->orderBy('created_at', 'desc')->first();
                $status = OrderStatus::where('id', $statusUpdate->status_id)->first();
                $item->order_status_name = $status->name;
                $item->status_code = $status->code;
            }
            $order_items['order'] = $order;
            $order_items['order_items'] = $orderItems;

            $response['data'] = $order_items;
            $response['errors'] = false;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function recentOrders()
    {
        try {
            $user_id = Auth::guard('user-api')->id();
            $date = Carbon::today()->subDays(7);

            $orderItems = DB::table('order_items')
                ->leftJoin('orders', 'orders.id', '=', 'order_items.order_id')
                ->leftJoin('products', 'products.id', '=', 'order_items.product_id')
                ->select('order_items.*', 'products.title', 'products.main_image')
                ->where([['orders.user_id', $user_id], ['orders.created_at', '>=', $date]])
                ->orderBy('order_items.created_at', 'desc')
                ->get();

            foreach ($orderItems as $item) {
                $item->main_image = env('APP_URL') . '/storage/product/' . $item->main_image;
                $item->created_at = date("d M Y", strtotime($item->created_at));
                $item->updated_at = date("d M Y", strtotime($item->updated_at));

                $statusUpdate = ItemStatusUpdate::where('order_item_id', $item->id)->orderBy('created_at', 'desc')->first();
                $status = OrderStatus::where('id', $statusUpdate->status_id)->first();
                $item->order_status_name = $status->name;
                $item->status_code = $status->code;
            }

            $response['data'] = $orderItems;
            $response['errors'] = false;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function recentOrderDetail($id)
    {
        try {
            $orderItem = DB::table('order_items')
                ->leftJoin('products', 'products.id', '=', 'order_items.product_id')
                ->select('order_items.*', 'products.title', 'products.main_image')
                ->where('order_items.id', $id)
                ->first();

            $orderItem->main_image = env('APP_URL') . '/storage/product/' . $orderItem->main_image;
            $orderItem->created_at = date("d M Y", strtotime($orderItem->created_at));
            $orderItem->updated_at = date("d M Y", strtotime($orderItem->updated_at));

            $statusUpdate = ItemStatusUpdate::where('order_item_id', $orderItem->id)->orderBy('created_at', 'desc')->first();
            $status = OrderStatus::where('id', $statusUpdate->status_id)->first();
            $orderItem->order_status_name = $status->name;
            $orderItem->status_code = $status->code;

            $response['data'] = $orderItem;
            $response['errors'] = false;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function createOrderReturns($request)
    {
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

            $statusUpdate = new ItemStatusUpdate;
            $statusUpdate->order_id = $request['order_id'];
            $statusUpdate->order_item_id = $request['order_item_id'];
            $statusUpdate->user_id = $user_id;
            $statusUpdate->vendor_id = $request['vendor_id'];
            $statusUpdate->status_id = 7;
            $statusUpdate->updated_by = 'system';
            $statusUpdate->save();

            //update notification table
            $vendorData = Vendor::where('id', $request['vendor_id'])->first();
            $productData = Product::where('id', $request['product_id'])->first();
            $notification = new Notification;
            $notification->date = date("d M Y");
            $notification->device_id = $vendorData->device_id;
            $notification->receiver_id = $request['vendor_id'];
            $notification->receiver_type = 'V';
            $notification->title = "Order Returns";
            $notification->message = "You have received Order Returnd for - " . $productData->title;
            $notification->status = 0;
            $notification->save();

            $response['message'] = 'success';
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        } 
        catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}