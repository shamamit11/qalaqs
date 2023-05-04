<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubcategoryRequest;
use App\Services\Admin\SubcategoryService;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Subcategory;

class SubcategoryController extends Controller
{
    protected $subcategory;

    public function __construct(SubcategoryService $SubcategoryService)
    {
        $this->subcategory = $SubcategoryService;
    }

    public function index(Request $request)
    {
        $nav = 'subcategory';
        $sub_nav = '';
        $per_page = 100;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $page_title = ' Subcategory';
        $result = $this->subcategory->list($per_page, $page, $q);
        return view('admin.subcategory.index', compact('nav', 'sub_nav', 'page_title'), $result);
    }

    public function status(Request $request)
    {
        $this->subcategory->status($request);
    }

    public function addEdit(Request $request)
    {
        $nav = 'subcategory';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $data['title'] = $page_title = ($id == 0) ? "Add Subcategory" : "Edit Subcategory";
        $data['action'] = route('admin-subcategory-addaction');
        $data['order'] = getMax('subcategories', 'order');
        $data['categories'] = Category::where('status', 1)->orderBy('order', 'asc')->get();
        $data['row'] = Subcategory::where('id', $id)->first();
        return view('admin.subcategory.add', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function addAction(SubcategoryRequest $request)
    {
        return $this->subcategory->store($request->validated());
    }

    public function delete(Request $request)
    {
        return $this->subcategory->delete($request);
    }
    
    public function imageDelete(Request $request)
    {
        return $this->subcategory->imageDelete($request);
    }
}
