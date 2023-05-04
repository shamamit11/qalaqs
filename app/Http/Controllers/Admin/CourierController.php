<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CourierRequest;
use App\Services\Admin\CourierService;
use Illuminate\Http\Request;
use App\Models\Courier;

class CourierController extends Controller
{
    protected $courier;

    public function __construct(CourierService $CourierService)
    {
        $this->courier = $CourierService;
    }

    public function index(Request $request)
    {
        $user_type = checkIfUserIsStandardUser();
        if($user_type) {
            return redirect()->route('admin-dashboard');
        }

        $nav = 'courier';
        $sub_nav = '';
        $per_page = 10;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $page_title = 'Couriers';
        $result = $this->courier->list($per_page, $page, $q);
        return view('admin.couriers.index', compact('nav', 'sub_nav', 'page_title'), $result);
    }

    public function status(Request $request)
    {
        $this->courier->status($request);
    }

    public function addEdit(Request $request)
    {
        $user_type = checkIfUserIsStandardUser();
        if($user_type) {
            return redirect()->route('admin-dashboard');
        }

        $nav = 'courier';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $data['title'] = $page_title = ($id == 0) ? "Add Courier" : "Edit Courier";
        $data['action'] = route('admin-courier-addaction');
        $data['row'] = Courier::where('id', $id)->first();
        return view('admin.couriers.add', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function addAction(CourierRequest $request)
    {
        return $this->courier->store($request->validated());
    }

    public function view(Request $request)
    {
        $user_type = checkIfUserIsStandardUser();
        if($user_type) {
            return redirect()->route('admin-dashboard');
        }

        $nav = 'courier';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $page_title = 'Courier Details';
        $data['title'] = ($id == 0) ? "Add Courier" : "View Courier";
        $data['row'] = Courier::where('id', $id)->first();
        return view('admin.couriers.view', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function delete(Request $request)
    {
        return $this->courier->delete($request);
    }

    public function imageDelete(Request $request)
    {
        return $this->courier->imageDelete($request);
    }
}
