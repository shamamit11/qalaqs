<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use App\Models\Suitablefor;
use App\Services\Admin\ProductService;
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
        $user_type = checkIfUserIsStandardUser();
        if($user_type) {
            return redirect()->route('admin-dashboard');
        }

        $nav = 'product';
        $sub_nav = '';
        $per_page = 10;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $page_title = 'Products';
        $result = $this->product->list($per_page, $page, $q);
        return view('admin.product.index', compact('nav', 'sub_nav', 'page_title'), $result);
    }

    public function status(Request $request)
    {
        $this->product->status($request);
    }

    public function view(Request $request)
    {
        $user_type = checkIfUserIsStandardUser();
        if($user_type) {
            return redirect()->route('admin-dashboard');
        }

        $nav = 'product';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $page_title = 'Product Details';
        $data['title'] = ($id == 0) ? "Add Product" : "View Product";
        $data['row'] = Product::where('id', $id)->first();
        $data['views'] = DB::table('product_views')->where('product_id', $id)->first();
        $data['matches'] = Suitablefor::where('product_id', $id)->get();
        $data['reviews'] = ProductReview::where('product_id', $id)->get();
        return view('admin.product.view', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    // public function addAction(ProductRequest $request)
    // {
    //     return $this->product->store($request->validated());
    // }

    public function delete(Request $request)
    {
        return $this->product->delete($request);
    }
}
