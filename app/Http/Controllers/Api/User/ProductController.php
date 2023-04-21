<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Product\OtherProductRequest;
use App\Services\Api\User\ProductService;
use Illuminate\Http\Request;
use App\Http\Requests\Api\User\Product\SearchRequest;

class ProductController extends Controller
{
    protected $product;

    public function __construct(ProductService $ProductService)
    {
        $this->product = $ProductService;
    }

    public function topDeals($limit) {
        return $this->product->topDeals($limit);
    }

    public function featuredProducts($limit) {
        return $this->product->featuredProducts($limit);
    }
    
    public function productDetail($id) {
        $this->product->addProductView($id);
        return $this->product->productDetail($id);
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

    public function getCategories() {
        return $this->product->getCategories();
    }

    public function getSubcategories($category_id) {
        return $this->product->getSubcategories($category_id);
    }

    public function searchResult(SearchRequest $request) {
        return $this->product->searchResult($request->validated());
    }

    public function listOtherCategories() {
        return $this->product->listOtherCategories();
    }

    public function listProductByOtherCategories($category_id) {
        return $this->product->listProductByOtherCategories($category_id);
    }   
}
