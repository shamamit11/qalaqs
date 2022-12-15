<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\YearRequest;
use App\Services\Admin\YearService;
use Illuminate\Http\Request;

use App\Models\ProductMake;
use App\Models\ProductModel;
use App\Models\ProductYear;


class YearController extends Controller
{
    protected $year;

    public function __construct(YearService $YearService)
    {
        $this->year = $YearService;
    }

    public function index(Request $request)
    {
        $nav = 'year';
        $sub_nav = '';
        $per_page = 10;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $page_title = 'Product Years';
        $result = $this->year->List($per_page, $page, $q);
        return view('admin.year.index', compact('nav', 'sub_nav', 'page_title'), $result);
    }

    public function status(Request $request)
    {
        $this->year->status($request);
    }

    public function addEdit(Request $request)
    {
        $nav = 'year';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $page_title = 'Product Years';
        $data['title'] = ($id == 0) ? "Add Year" : "Edit Year"; 
        $data['action'] = route('admin-year-addaction');
        $data['makes'] = ProductMake::where('status', 1)->orderBy('name', 'asc')->get();
        $data['models'] = ProductModel::where('status', 1)->orderBy('name', 'asc')->get();
        $data['row'] = ProductYear::where('id', $id)->first();
        return view('admin.year.add', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function addAction(YearRequest $request)
    {
        return $this->year->store($request->validated());
    }

    public function delete(Request $request)
    {
        echo $this->year->delete($request);
    }
}