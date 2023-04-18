<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Vendor\Product\EngineRequest;
use App\Http\Requests\Api\Vendor\Product\ModelRequest;
use App\Http\Requests\Api\Vendor\Product\ProductRequest;
use App\Http\Requests\Api\Vendor\Product\SubcategoryRequest;
use App\Http\Requests\Api\Vendor\Product\SuitableRequest;
use App\Http\Requests\Api\Vendor\Product\YearRequest;
use App\Services\Api\Vendor\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $product;

    public function __construct(ProductService $ProductService)
    {
        $this->product = $ProductService;
    }

    public function getMakes() {
        return $this->product->getMakes();
    }

    public function getModels($make_id) {
        return $this->product->getModels($make_id);
    }

    public function getYears($make_id, $model_id) {
        return $this->product->getYears($make_id, $model_id);
    }

    public function getEngines($make_id, $model_id, $year_id) {
        return $this->product->getEngines($make_id, $model_id, $year_id);
    }

    public function brand() {
        return $this->product->brand();
    }

    public function category() {
        return $this->product->category();
    }

    public function getSubcategory($category_id) {
        return $this->product->getSubcategory($category_id);
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
