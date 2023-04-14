<?php
namespace App\Services\Vendor;

use App\Models\ItemStatusUpdate;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderReturn;
use App\Models\OrderStatus;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{ 

    function list($per_page, $page, $q) {
        try {
            $vendor_id = Auth::guard('vendor')->id();
            $data['q'] = $q;
            $query = OrderItem::select('*')->with('order')->with('product')->with('order_status');
            if ($q) {
                $search_key = $q;
                $query->where(function ($qry) use ($search_key) {
                    $qry->where('id', 'LIKE', '%' . $search_key . '%');
                    $qry->orWhereHas('order', function ($qry1) use ($search_key) {
                        $qry1->where('order_id', 'LIKE', '%' . $search_key . '%');
                    });
                    $qry->orWhereHas('product', function ($qry2) use ($search_key) {
                        $qry2->where('title', 'LIKE', '%' . $search_key . '%');
                    });
                    $qry->orWhereHas('order_status', function ($qry3) use ($search_key) {
                        $qry3->where('name', 'LIKE', '%' . $search_key . '%');
                    });
                });
            }
            $data['orders'] = $query->where('vendor_id', $vendor_id)->orderBy('created_at', 'desc')->paginate($per_page);
            $data['orders']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['orders']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['orders']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['orders']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['orders']->count();
            }
            return $data;
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function updateOrderStatus($request) {
        try {
            $itemStatus = ItemStatusUpdate::where('order_item_id', $request['order_item_id'])->first();
            $itemStatus->status_id = $request['status_id'];
            $itemStatus->save();
            $response['message'] = 'success';
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        }
        catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function listReturns($per_page, $page, $q) {
        try {
            $vendor_id = Auth::guard('vendor')->id();
            $data['q'] = $q;
            $query = OrderReturn::select('*');
            if ($q) {
                $search_key = $q;
                $query->where(function ($qry) use ($search_key) {
                    $qry->where('id', 'LIKE', '%' . $search_key . '%');
                });
            }
            $data['returns'] = $query->where('vendor_id', $vendor_id)->orderBy('created_at', 'desc')->paginate($per_page);
            $data['returns']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['returns']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['returns']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['returns']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['returns']->count();
            }
            return $data;
        }
        catch (\Exception$e) {
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
            $orderReturns->product_image =  env('APP_URL').'/storage/product/'.$product->main_image;

            $orderItem = OrderItem::where('id', $orderReturns->order_item_id)->first();
            $orderReturns->order_placed_on = date("d M Y", strtotime($orderItem->created_at));

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