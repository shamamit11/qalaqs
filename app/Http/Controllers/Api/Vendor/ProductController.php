<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Vendor\Product\ProductRequest;
use App\Services\Api\Vendor\ProductService;
use Illuminate\Http\Request;

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

    public function addEdit(ProductRequest $request) {
        return $this->product->store($request->validated());
    }

}
