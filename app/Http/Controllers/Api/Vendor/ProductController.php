<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Vendor\Product\ProductRequest;
use App\Http\Requests\Api\Vendor\Product\SuitableRequest;
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

    public function brand() {
        return $this->product->brand();
    }


    public function category() {
        return $this->product->category();
    }

    public function subcategory() {
        return $this->product->subcategory();
    }

    public function list() {
        return $this->product->listProducts();
    }

    public function addEdit(ProductRequest $request) {
        return $this->product->store($request->validated());
    }

    public function productDetail($id) {
        return $this->product->productDetail($id);
    }

    public function deleteProduct($id) {
        return $this->product->deleteProduct($id);
    }

    public function productSuitable($prod_id) {
        return $this->product->productSuitable($prod_id);
    }

    public function addSuitable(SuitableRequest $request) {
        return $this->product->addSuitable($request->validated());
    }

    public function deleteSuitable($suitable_id) {
        return $this->product->deleteSuitable($suitable_id);
    }

}
