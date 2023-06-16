<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductImageRequest;
use App\Models\Category;
use App\Models\Make;
use App\Models\Models;
use App\Models\Subcategory;
use App\Models\Year;
use App\Services\Admin\ProductImageService;
use Illuminate\Http\Request;

use App\Models\ProductImage;

class ProductImageController extends Controller
{
    protected $productImage;

    public function __construct(ProductImageService $ProductImageService)
    {
        $this->productImage = $ProductImageService;
    }

    public function index(Request $request)
    {
        $nav = 'productImage';
        $sub_nav = '';
        $per_page = 100;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $page_title = ' Product Images';
        $result = $this->productImage->list($per_page, $page, $q);
        return view('admin.productImage.index', compact('nav', 'sub_nav', 'page_title'), $result);
    }

    public function status(Request $request)
    {
        $this->productImage->status($request);
    }

    public function addEdit(Request $request)
    {
        $nav = 'productImage';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $data['title'] = $page_title = ($id == 0) ? "Add Product Image" : "Edit Product Image";
        $data['action'] = route('admin-product-image-addaction');
        $data['categories'] = Category::where('status', 1)->get();
        $data['subcategories'] = Subcategory::where('status', 1)->get();
        $data['makes'] = Make::where('status', 1)->get();
        $data['models'] = Models::where('status', 1)->get();
        $data['years'] = Year::where('status', 1)->get();
        $data['row'] = ProductImage::where('id', $id)->first();
        return view('admin.productImage.add', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function addAction(ProductImageRequest $request)
    {
        return $this->productImage->store($request->validated());
    }

    public function delete(Request $request)
    {
        return $this->productImage->delete($request);
    }
}
