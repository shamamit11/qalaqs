<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MakeRequest;
use App\Services\Admin\MakeService;
use Illuminate\Http\Request;

use App\Models\Make;

class MakeController extends Controller
{
    protected $make;

    public function __construct(MakeService $MakeService)
    {
        $this->make = $MakeService;
    }

    public function index(Request $request)
    {
        $nav = 'make';
        $sub_nav = '';
        $per_page = 300;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $page_title = ' Makes';
        $result = $this->make->list($per_page, $page, $q);
        return view('admin.make.index', compact('nav', 'sub_nav', 'page_title'), $result);
    }

    public function status(Request $request)
    {
        $this->make->status($request);
    }

    public function addEdit(Request $request)
    {
        $nav = 'make';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $data['title'] = $page_title = ($id == 0) ? "Add Make" : "Edit Make";
        $data['action'] = route('admin-make-addaction');
        $data['row'] = Make::where('id', $id)->first();
        return view('admin.make.add', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function addAction(MakeRequest $request)
    {
        return $this->make->store($request->validated());
    }

    public function delete(Request $request)
    {
        return $this->make->delete($request);
    }
    

    public function vendors(Request $request)
    {
        $nav = 'make';
        $sub_nav = '';
        $per_page = 300;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $makeObj = Make::where('id', $request->id)->first();
        $page_title = 'Vendors Dealing with ' . $makeObj->name;
        $result = $this->make->vendors($per_page, $page, $request->id);
        return view('admin.make.vendor', compact('nav', 'sub_nav', 'page_title'), $result);
    }
}
