<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\OrderStatusRequest;
use App\Models\Order;
use App\Models\OrderItem;
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
        $per_page = 10;
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
        return view('admin.order.view', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function updateOrderStatus(OrderStatusRequest $request) {
        return $this->order->updateOrderStatus($request);
    }

    public function listReturns() {
        return $this->order->listReturns();
    }

    public function returnDetail($return_id) {
        return $this->order->returnDetail($return_id);
    }
}
