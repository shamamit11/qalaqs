<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Product\OtherProductRequest;
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

    public function topDeals($count) {
        return $this->product->topDeals($count);
    }

    public function featuredProducts($count) {
        return $this->product->featuredProducts($count);
    }
    
    public function productDetail($id) {
        $this->product->addProductView($id);
        return $this->product->productDetail($id);
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

    public function listOtherCategories() {
        return $this->product->listOtherCategories();
    }

    public function listProductByOtherCategories($category_id) {
        return $this->product->listProductByOtherCategories($category_id);
    }

    
}
