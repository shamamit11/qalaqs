<?php

namespace App\Http\Controllers\Courier;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\OrderReturn;
use App\Services\Courier\OrderReturnService;
use App\Services\Courier\OrderService;
use Illuminate\Http\Request;
use App\Models\Order;

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
        $page_title = 'Orders';
        $result = $this->order->list($per_page, $page, $q);
        return view('courier.order.index', compact('nav', 'sub_nav', 'page_title'), $result);
    }

    public function view(Request $request)
    {
        $nav = 'order';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $data['title'] = $page_title =($id == 0) ? "Orders" : "View Order";
        $data['row'] = Order::where('id', $id)->first();
        $data['items'] = OrderItem::where('order_id', $id)->get();
        return view('courier.order.view', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function returns(Request $request)
    {
        $nav = 'return';
        $sub_nav = '';
        $per_page = 100;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $page_title = 'Order Returns';
        $order_return = new OrderReturnService;
        $result = $order_return->list($per_page, $page, $q);
        return view('courier.order.return', compact('nav', 'sub_nav', 'page_title'), $result);
    }

    public function returnView(Request $request)
    {
        $nav = 'return';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $data['title'] = $page_title =($id == 0) ? "Orders" : "View Returns";
        $data['row'] = $return = OrderReturn::where('id', $id)->first();
        return view('courier.order.returnview', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function returnStatus(Request $request)
    {
        $order_return = new OrderReturnService;
        $order_return->status($request);
    }
}
