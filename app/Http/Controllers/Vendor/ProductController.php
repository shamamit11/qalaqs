<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\ProductMatchRequest;
use App\Http\Requests\Vendor\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Engine;
use App\Models\Make;
use App\Models\Models;
use App\Models\ProductReview;
use App\Models\Subcategory;
use App\Models\Suitablefor;
use App\Models\Year;
use App\Services\Vendor\ProductService;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    protected $product;

    public function __construct(ProductService $ProductService)
    {
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
        $result = $this->product->list($per_page, $page, $q);
        return view('vendor.product.index', compact('nav', 'sub_nav', 'page_title'), $result);
    }

    public function view(Request $request)
    {
        $nav = 'product';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $page_title = 'Product Details';
        $data['title'] = ($id == 0) ? "Add Product" : "View Product";
        $data['row'] = Product::where('id', $id)->first();
        $data['views'] = DB::table('product_views')->where('product_id', $id)->first();
        $data['matches'] = Suitablefor::where('product_id', $id)->get();
        $data['reviews'] = ProductReview::where('product_id', $id)->get();
        return view('vendor.product.view', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function addEdit(Request $request)
    {
        $nav = 'product';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $data['title'] = $page_title = ($id == 0) ? "Add Product" : "Edit Product";
        $data['action'] = route('vendor-product-addaction');
        $data['row'] = Product::where('id', $id)->first();
        $data['makes'] = Make::where('status', 1)->orderBy('name', 'asc')->get();
        $data['models'] = Models::where('status', 1)->orderBy('name', 'asc')->get();
        $data['years'] = Year::where('status', 1)->orderBy('name', 'asc')->get();
        $data['engines'] = Engine::where('status', 1)->orderBy('name', 'asc')->get();
        $data['categories'] = Category::where('status', 1)->orderBy('order', 'asc')->get();
        $data['subcategories'] = Subcategory::where('status', 1)->orderBy('order', 'asc')->get();
        $data['brands'] = Brand::where('status', 1)->orderBy('order', 'asc')->get();
        if($request->id) {
            $data['matches'] = Suitablefor::where('product_id', $id)->get();
        } else {
            $data['matches'] = [];
        }
        return view('vendor.product.add', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function addAction(ProductRequest $request)
    {
        return $this->product->store($request->validated());
    }

    public function addMatch(Request $request)
    {
        $nav = 'product';
        $sub_nav = '';
        $data['title'] = $page_title = "Add Suitable Product";
        $data['action'] = route('vendor-product-addmatchaction');
        $data['product'] = Product::where('id', $request->id)->first();
        $data['product_id'] = $request->id;
        $data['makes'] = Make::where('status', 1)->orderBy('name', 'asc')->get();
        $data['models'] = Models::where('status', 1)->orderBy('name', 'asc')->get();
        $data['years'] = Year::where('status', 1)->orderBy('name', 'asc')->get();
        $data['engines'] = Engine::where('status', 1)->orderBy('name', 'asc')->get();
        return view('vendor.product.match', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function addMatchAction(ProductMatchRequest $request)
    {
        return $this->product->addMatchAction($request->validated());
    }

    public function deleteMatch(Request $request)
    {
        return $this->product->deleteMatch($request);
    }
}
