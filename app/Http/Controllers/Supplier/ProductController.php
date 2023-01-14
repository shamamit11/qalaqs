<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\MatchRequest;
use App\Http\Requests\Supplier\ProductImageRequest;
use App\Http\Requests\Supplier\ProductOrderImageRequest;
use App\Http\Requests\Supplier\ProductRequest;
use App\Http\Requests\Supplier\SpecificationRequest;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\ProductEngine;
use App\Models\ProductMake;
use App\Models\ProductMatch;
use App\Models\ProductModel;
use App\Models\ProductPart;
use App\Models\ProductSubCategory;
use App\Models\ProductType;
use App\Models\ProductYear;
use App\Services\Supplier\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected $product;

    public function __construct(ProductService $ProductService)
    {
        $this->middleware(function ($request, $next) {
            if (Auth::guard('supplier')->user()->admin_approved == 0) {
                return redirect(route('supplier-dashboard'));
            } else {
                return $next($request);
            }

        });
        $this->product = $ProductService;
    }

    public function index(Request $request)
    {
        $nav = 'product';
        $sub_nav = '';
        $per_page = 10;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $page_title = 'Products';
        $result = $this->product->List($per_page, $page, $q);
        return view('supplier.product.index', compact('nav', 'sub_nav', 'page_title'), $result);
    }

    public function status(Request $request)
    {
        $this->product->status($request);
    }

    public function addEdit(Request $request)
    {
        $nav = 'product';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $page_title = 'Products';
        $data['title'] = ($id == 0) ? "Add Product" : "Edit Product";
        $data['action'] = route('supplier-product-addaction');
        $data['categories'] = ProductCategory::where('status', 1)->orderBy('order', 'asc')->get();
        $data['subcategories'] = ProductSubCategory::where('status', 1)->orderBy('order', 'asc')->get();
        $data['brands'] = ProductBrand::where('status', 1)->orderBy('order', 'asc')->get();
        $data['makes'] = ProductMake::where('status', 1)->orderBy('name', 'asc')->get();
        $data['models'] = ProductModel::where('status', 1)->orderBy('name', 'asc')->get();
        $data['parts'] = ProductPart::orderBy('name', 'asc')->get();
        $data['product_types'] = ProductType::orderBy('name', 'asc')->get();
        $data['years'] = ProductYear::where('status', 1)->orderBy('name', 'asc')->get();
        $data['engines'] = ProductEngine::where('status', 1)->orderBy('name', 'asc')->get();
        $data['row'] = Product::where('id', $id)->first();
        return view('supplier.product.add', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function addAction(ProductRequest $request)
    {
        return $this->product->store($request->validated());
    }

    public function delete(Request $request)
    {
        echo $this->product->delete($request);
    }

    public function specification(Request $request)
    {
        $data['product'] = Product::with('specifications')->where('id', $request->id)->first();
        $data['cnt'] = 1;
        return view('supplier.product.specification', $data);
    }

    public function addSpecification(SpecificationRequest $request)
    {
        return $this->product->addSpecification($request->validated());
    }

    public function deleteSpecification(Request $request)
    {
        echo $this->product->deleteSpecification($request);
    }

    function match(Request $request) {
        $data['cnt'] = 1;
        $data['product'] = Product::with('matches')->where('id', $request->id)->first();
        $data['engines'] = ProductEngine::with('make')->with('model')->with('year')->where('status', 1)->orderBy('name', 'asc')->get();
        return view('supplier.product.match', $data);
    }

    public function addMatch(MatchRequest $request)
    {
        return $this->product->addMatch($request->validated());
    }

    public function deleteMatch(Request $request)
    {
        echo $this->product->deleteMatch($request);
    }

    // public function addMatch(MatchRequest $request)
    // {
    //     $message = $this->product->addMatch($request->validated());
    //     return redirect()->route('supplier-product')->withMessage($message);
    // }

    public function images(Request $request)
    {
        $data['cnt'] = 1;
        $data['product'] = Product::with('images')->where('id', $request->id)->first();
        return view('supplier.product.image', $data);
    }

    public function saveImage(ProductImageRequest $request)
    {
        return $this->product->saveImage($request->validated());
    }

    public function orderImage(ProductOrderImageRequest $request)
    {
        return $this->product->orderImage($request->validated());
    }

    public function imageStatus(Request $request)
    {
        $this->product->imageStatus($request);
    }

    public function imageDelete(Request $request)
    {
        echo $this->product->imageDelete($request);
    }
}
