<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Services\Admin\CategoryService;
use Illuminate\Http\Request;

use App\Models\ProductCategory;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(CategoryService $CategoryService)
    {
        $this->category = $CategoryService;
    }

    public function index(Request $request)
    {
        $nav = 'category';
        $sub_nav = '';
        $per_page = 10;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $page_title = 'Product Category';
        $result = $this->category->List($per_page, $page, $q);
        return view('admin.category.index', compact('nav', 'sub_nav', 'page_title'), $result);
    }

    public function status(Request $request)
    {
        $this->category->status($request);
    }

    public function addEdit(Request $request)
    {
        $nav = 'category';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $page_title = 'Product Category';
        $data['title'] = ($id == 0) ? "Add Category" : "Edit Category";
        $data['action'] = route('admin-category-addaction');
        $data['order'] = getMax('product_categories', 'order');
        $data['row'] = ProductCategory::where('id', $id)->first();
        return view('admin.category.add', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function addAction(CategoryRequest $request)
    {
        return $this->category->store($request->validated());
    }

    public function delete(Request $request)
    {
        echo $this->category->delete($request);
    }
    
    public function imageDelete(Request $request)
    {
        echo $this->category->imageDelete($request);
    }
}
