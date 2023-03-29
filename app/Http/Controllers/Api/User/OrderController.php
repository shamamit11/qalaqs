<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Order\PaymentRequest;
use App\Http\Requests\Api\User\Order\OrderRequest;
use App\Services\Api\User\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $order;

    public function __construct(OrderService $OrderService)
    {
        $this->order = $OrderService;
    }

    public function processPayment(PaymentRequest $request) {
        return $this->order->processPayment($request);  
    }

    public function createOrder(OrderRequest $request) {
        return $this->order->createOrder($request);
    }

    public function listOrders() {
        return $this->order->listOrders();
    }

    public function getOrderDetails($order_id) {
        return $this->order->getOrderDetails($order_id);
    }
}
