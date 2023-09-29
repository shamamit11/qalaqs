<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AutoServiceRequest;
use App\Services\Admin\FeaturedService;
use Illuminate\Http\Request;
use App\Models\AutoService;

class AutoServiceController extends Controller
{
    protected $autoservice;

    public function __construct(FeaturedService $FeaturedService)
    {
        $this->autoservice = $FeaturedService;
    }

    public function index(Request $request)
    {
        $user_type = checkIfUserIsStandardUser();
        if($user_type) {
            return redirect()->route('admin-dashboard');
        }

        $nav = 'autoservice';
        $sub_nav = '';
        $per_page = 100;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $page_title = 'Garages';
        $result = $this->autoservice->list($per_page, $page, $q);
        return view('admin.autoservice.index', compact('nav', 'sub_nav', 'page_title'), $result);
    }

    public function status(Request $request)
    {
        $this->autoservice->status($request);
    }

    public function addEdit(Request $request)
    {
        $user_type = checkIfUserIsStandardUser();
        if($user_type) {
            return redirect()->route('admin-dashboard');
        }

        $nav = 'autoservice';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $data['title'] = $page_title = ($id == 0) ? "Add Auto Service" : "Edit Auto Service";
        $data['action'] = route('admin-autoservice-addaction');
        $data['row'] = AutoService::where('id', $id)->first();
        return view('admin.autoservice.add', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function addAction(AutoServiceRequest $request)
    {
        return $this->autoservice->store($request->validated());
    }

    public function delete(Request $request)
    {
        echo $this->autoservice->delete($request);
    }
}
