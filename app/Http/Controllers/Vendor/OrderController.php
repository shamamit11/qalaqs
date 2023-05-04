<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\OrderStatusRequest;
use App\Models\ItemStatusUpdate;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderReturn;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Services\Vendor\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $order;

    public function __construct(OrderService $OrderService)
    {
        $this->order = $OrderService;
    }

    public function index(Request $request)
    {
        $nav = 'order';
        $sub_nav = '';
        $per_page = 100;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $page_title = 'My Orders';
        $result = $this->order->list($per_page, $page, $q);
        return view('vendor.order.index', compact('nav', 'sub_nav', 'page_title'), $result);
    }

    public function view(Request $request)
    {
        $nav = 'order';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $data['title'] = $page_title =($id == 0) ? "Orders" : "View Order";
        $data['item'] = $order_item = OrderItem::where('id', $id)->first();
        $data['order'] = Order::where('id', $order_item->order_id)->first();
        $data['orderstatuses'] =  OrderStatus::get();
        return view('vendor.order.view', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function updateOrderStatus(Request $request) {
        return $this->order->updateOrderStatus($request);
    }

    public function listReturns(Request $request) {
        $nav = 'return';
        $sub_nav = '';
        $per_page = 100;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $page_title = 'Returns & Exchanges';
        $result = $this->order->listReturns($per_page, $page, $q);
        return view('vendor.order.return', compact('nav', 'sub_nav', 'page_title'), $result);
    }

    public function returnDetail(Request $request) {
        $nav = 'return';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $data['title'] = $page_title =($id == 0) ? "Orders" : "View Return";
        $orderReturns = OrderReturn::where([['id', $request->id]])->first()->makeHidden(['created_at', 'updated_at']);
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

        $data['row'] = $orderReturns;
        
        return view('vendor.order.returnview', compact('nav', 'sub_nav', 'page_title'), $data);
    }
}
