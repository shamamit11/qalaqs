<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Services\Admin\CategoryService;
use Illuminate\Http\Request;

use App\Models\Category;

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
        $page_title = ' Category';
        $result = $this->category->list($per_page, $page, $q);
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
        $data['title'] = $page_title = ($id == 0) ? "Add Category" : "Edit Category";
        $data['action'] = route('admin-category-addaction');
        $data['order'] = getMax('categories', 'order');
        $data['row'] = Category::where('id', $id)->first();
        return view('admin.category.add', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function addAction(CategoryRequest $request)
    {
        return $this->category->store($request->validated());
    }

    public function delete(Request $request)
    {
        return $this->category->delete($request);
    }
    
    public function imageDelete(Request $request)
    {
        return $this->category->imageDelete($request);
    }
}
