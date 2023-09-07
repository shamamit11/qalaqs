<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpecialOrder;
use App\Services\Admin\SpecialRequestService;
use Illuminate\Http\Request;

class SpecialRequestController extends Controller
{
    protected $specialrequest;

    public function __construct(SpecialRequestService $SpecialRequestService)
    {
        $this->specialrequest = $SpecialRequestService;
    }

    public function index(Request $request)
    {
        $nav = 'specialrequest';
        $sub_nav = '';
        $per_page = 100;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $page_title = 'Special Requests';
        $result = $this->specialrequest->list($per_page, $page, $q);
        return view('admin.specialrequest.index', compact('nav', 'sub_nav', 'page_title'), $result);
    }

    public function view(Request $request)
    {
        $nav = 'specialrequest';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $data['title'] = $page_title =($id == 0) ? "View Special Request" : "View Special Request";
        $data['row'] = SpecialOrder::where('id', $id)->first();
        return view('admin.specialrequest.view', compact('nav', 'sub_nav', 'page_title'), $data);
    }
}
