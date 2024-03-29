<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Order\OrderReturnRequest;
use App\Http\Requests\Api\User\Order\PaymentTokenRequest;
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

    public function generatePaymentToken(PaymentTokenRequest $request) {
        return $this->order->generatePaymentToken($request);
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

    public function listReturns() {
        return $this->order->listReturns();
    }

    public function recentOrders() {
        return $this->order->recentOrders();
    }

    public function recentOrderDetail($id) {
        return $this->order->recentOrderDetail($id);
    }

    public function createOrderReturns(OrderReturnRequest $request) {
        return $this->order->createOrderReturns($request);
    }
}
