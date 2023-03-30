<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Vendor\Order\OrderStatusRequest;
use App\Services\Api\Vendor\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $order;

    public function __construct(OrderService $OrderService)
    {
        $this->order = $OrderService;
    }

    public function listOrders() {
        return $this->order->listOrders();
    }

    public function orderDetails($order_item_id) {
        return $this->order->orderDetails($order_item_id);
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
