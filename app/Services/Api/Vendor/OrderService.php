<?php
namespace App\Services\Api\Vendor;

use App\Models\ItemStatusUpdate;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderReturn;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use ExpoSDK\Expo;
use ExpoSDK\ExpoMessage;

class OrderService
{ 
    public function listOrders() {
        try {
            $vendor_id = Auth::guard('vendor-api')->user()->id;
            $orderItems = OrderItem::where('vendor_id', $vendor_id)->orderBy('created_at', 'desc')->get()->makeHidden(['created_at', 'updated_at', 'delivery_distance', 'delivery_charge', 'cod_charge']);
            
            foreach($orderItems as $item) {
                $order = Order::where('id', $item->order_id)->first();
                $item->order_code = $order->order_id;

                $product = Product::where('id', $item->product_id)->first();
                $item->product_title = $product->title;

                $productSubcategory = Subcategory::where('id', $product->subcategory_id);
                dd($productSubcategory);
                
                $item->product_image =  @$productSubcategory->icon;

                //$item->product_image =  env('APP_URL').'/storage/product/'.$product->main_image;
                $item->product_price = $product->price;
                $item->discount = $product->discount;

                $itemStatus = ItemStatusUpdate::where('order_item_id', $item->id)->orderBy('created_at', 'desc')->first();
                $status = OrderStatus::where('id', $itemStatus->status_id)->first();
                $item->status_code = $status->code;
                $item->status_name = $status->name;

                $item->created_date = date("d M Y", strtotime($item->created_at));
                $item->updated_date = date("d M Y", strtotime($item->updated_at));
            }

            $response['data'] = $orderItems;
            $response['errors'] = false;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function orderDetails($order_item_id) {
        try {
            $vendor_id = Auth::guard('vendor-api')->user()->id;
            $orderItem = OrderItem::where([['vendor_id', $vendor_id], ['id', $order_item_id]])->first()->makeHidden(['created_at', 'updated_at', 'delivery_distance', 'delivery_charge', 'cod_charge']);
           
            $order = Order::where('id', $orderItem->order_id)->first();
            $orderItem->order_code = $order->order_id;

            $product = Product::where('id', $orderItem->product_id)->first();
            $orderItem->product_title = $product->title;

            $productSubcategory = Subcategory::where('id', $product->subcategory_id);
            $orderItem->product_image =  $productSubcategory->icon;

            //$orderItem->product_image =  env('APP_URL').'/storage/product/'.$product->main_image;

            $itemStatus = ItemStatusUpdate::where('order_item_id', $orderItem->id)->orderBy('created_at', 'desc')->first();
            $orderStatus = OrderStatus::where('id', $itemStatus->status_id)->first();
            $orderItem->status_code = $orderStatus->code;
            $orderItem->status_name = $orderStatus->name;

            $orderItem->created_date = date("d M Y", strtotime($orderItem->created_at));
            $orderItem->updated_date = date("d M Y", strtotime($orderItem->updated_at));
       
            $response['data'] = $orderItem;
            $response['errors'] = false;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function updateOrderStatus($request) {
        try {
            $itemStatus = ItemStatusUpdate::where('order_item_id', $request['order_item_id'])->first();
            $itemStatus->status_id = $request['status_id'];
            $itemStatus->save();

            $order_item = OrderItem::where('id', $itemStatus->order_item_id)->first();
            $product_data = Product::where('id', $order_item->product_id)->first();
            $order_status = OrderStatus::where('id', $request['status_id'])->first();
            $user_data = User::where('id', $itemStatus->user_id)->first();

            //send Push Notification to User
            $messages = (new ExpoMessage([
                'title' => 'Qalaqs:',
                'body' => "Your Order - " . $product_data->title . " is " . $order_status->name,
            ]))
                ->setData(['id' => $itemStatus->id, "_displayInForeground" => true])
                ->setChannelId('default')
                ->setBadge(0)
                ->playSound();

            $defaultRecipients = [$user_data->device_id];
            $expo = new Expo();
            $expo->send($messages)->to($defaultRecipients)->push();

            $response['message'] = 'success';
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        }
        catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function listReturns() {
        try {
            $vendor_id = Auth::guard('vendor-api')->user()->id;
            $orderReturns = OrderReturn::where([['vendor_id', $vendor_id]])->orderBy('created_at', 'desc')->get()->makeHidden(['created_at', 'updated_at']);
            
            foreach($orderReturns as $item) {
                $order = Order::where('id', $item->order_id)->first();
                $item->order_code = $order->order_id;

                $product = Product::where('id', $item->product_id)->first();
                $item->product_title = $product->title;

                $productSubcategory = Subcategory::where('id', $product->subcategory_id);
                $item->product_image =  $productSubcategory->icon;

                //$item->product_image =  env('APP_URL').'/storage/product/'.$product->main_image;

                $order = OrderItem::where('id', $item->order_item_id)->first();
                $item->order_placed_on = date("d M Y", strtotime($order->created_at));

                $itemStatus = ItemStatusUpdate::where('order_item_id', $item->order_item_id)->orderBy('created_at', 'desc')->first();
                $orderStatus = OrderStatus::where('id', $itemStatus->status_id)->first();
                $item->status_code = $orderStatus->code;
                $item->status_name = $orderStatus->name;
            }

            $response['data'] = $orderReturns;
            $response['errors'] = false;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function returnDetail($return_id) {
        try {
            $vendor_id = Auth::guard('vendor-api')->user()->id;
            $orderReturns = OrderReturn::where([['vendor_id', $vendor_id], ['id', $return_id]])->first()->makeHidden(['created_at', 'updated_at']);
            
            $order = Order::where('id', $orderReturns->order_id)->first();
            $orderReturns->order_code = $order->order_id;

            $product = Product::where('id', $orderReturns->product_id)->first();
            $orderReturns->product_title = $product->title;

            $productSubcategory = Subcategory::where('id', $product->subcategory_id);
            $orderReturns->product_image =  $productSubcategory->icon;

            //$orderReturns->product_image =  env('APP_URL').'/storage/product/'.$product->main_image;

            $order = OrderItem::where('id', $orderReturns->order_item_id)->first();
            $orderReturns->order_placed_on = date("d M Y", strtotime($order->created_at));

            $itemStatus = ItemStatusUpdate::where('order_item_id', $orderReturns->order_item_id)->orderBy('created_at', 'desc')->first();
            $orderStatus = OrderStatus::where('id', $itemStatus->status_id)->first();
            $orderReturns->status_code = $orderStatus->code;
            $orderReturns->status_name = $orderStatus->name;
            
            $response['data'] = $orderReturns;
            $response['errors'] = false;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}