<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\SpecialOrder\SpecialOrderRequest;
use App\Services\Api\User\SpecialOrderService;

class SpecialOrderController extends Controller
{
    protected $order;

    public function __construct(SpecialOrderService $SpecialOrderService)
    {
        $this->order = $SpecialOrderService;
    }

    public function createSpecialOrder(SpecialOrderRequest $request) {
        return $this->order->createSpecialOrder($request);
    }
}
