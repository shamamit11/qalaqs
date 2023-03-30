<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Cart\CartDeleteRequest;
use App\Http\Requests\Api\User\Cart\CartRequest;
use App\Http\Requests\Api\User\Cart\PromoRequest;
use App\Services\Api\User\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cart;

    public function __construct(CartService $CartService)
    {
        $this->cart = $CartService;
    }

    public function list($cart_session_id) {
        return $this->cart->listCart($cart_session_id);
    }

    public function addItem(CartRequest $request) {
        return $this->cart->addItem($request);
    }

    public function updateQty(CartRequest $request) {
        return $this->cart->updateQty($request);
    }

    public function deleteItem(CartDeleteRequest $request) {
        return $this->cart->deleteItem($request);
    }

    public function itemCount($cart_session_id) {
        return $this->cart->itemCount($cart_session_id);
    }

    public function applyPromocode(PromoRequest $request) {
        return $this->cart->applyPromocode($request);
    }

    public function cartSummary($cart_session_id) {
        return $this->cart->cartSummary($cart_session_id);
    }
}
