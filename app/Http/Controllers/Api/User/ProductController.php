<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Services\Api\User\ProductService;
use Illuminate\Http\Request;
use App\Http\Requests\Api\User\Product\ProductRequest;

class ProductController extends Controller
{
    protected $product;

    public function __construct(ProductService $ProductService)
    {
        $this->product = $ProductService;
    }

    public function make() {
        return $this->product->make();
    }

    public function model() {
        return $this->product->model();
    }

    public function year() {
        return $this->product->year();
    }

    public function engine() {
        return $this->product->engine();
    }

    public function category() {
        return $this->product->category();
    }

    public function subcategory() {
        return $this->product->subcategory();
    }

    public function product(ProductRequest $request) {
        return $this->product->product($request->validated());
    }

    public function productDetail($id) {
        return $this->product->productDetail($id);
    }

    public function featuredProduct() {
        return $this->product->featuredProduct();
    }

    public function landingPageProduct() {
        return $this->product->landingPageProduct();
    }



}
