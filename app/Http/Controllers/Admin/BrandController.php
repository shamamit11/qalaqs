<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandRequest;
use App\Services\Admin\BrandService;
use Illuminate\Http\Request;

use App\Models\Brand;

class BrandController extends Controller
{
    protected $brand;

    public function __construct(BrandService $BrandService)
    {
        $this->brand = $BrandService;
    }

    public function index(Request $request)
    {
        $nav = 'brand';
        $sub_nav = '';
        $per_page = 10;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $page_title = ' Brands';
        $result = $this->brand->List($per_page, $page, $q);
        return view('admin.brand.index', compact('nav', 'sub_nav', 'page_title'), $result);
    }

    public function status(Request $request)
    {
        $this->brand->status($request);
    }

    public function addEdit(Request $request)
    {
        $nav = 'brand';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $page_title = 'Brands';
        $data['title'] = ($id == 0) ? "Add Brand" : "Edit Brand";
        $data['action'] = route('admin-brand-addaction');
        $data['order'] = getMax('brands', 'order');
        $data['row'] = Brand::where('id', $id)->first();
        return view('admin.brand.add', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function addAction(BrandRequest $request)
    {
        return $this->brand->store($request->validated());
    }

    public function delete(Request $request)
    {
        return  $this->brand->delete($request);
    }
    
    public function imageDelete(Request $request)
    {
        return  $this->brand->imageDelete($request);
    }
}
