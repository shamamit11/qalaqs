<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GarageRequest;
use App\Services\Admin\GarageService;
use Illuminate\Http\Request;
use App\Models\Garage;

class GarageController extends Controller
{
    protected $garage;

    public function __construct(GarageService $GarageService)
    {
        $this->garage = $GarageService;
    }

    public function index(Request $request)
    {
        $user_type = checkIfUserIsStandardUser();
        if($user_type) {
            return redirect()->route('admin-dashboard');
        }

        $nav = 'garage';
        $sub_nav = '';
        $per_page = 100;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $page_title = 'Garages';
        $result = $this->garage->list($per_page, $page, $q);
        return view('admin.garage.index', compact('nav', 'sub_nav', 'page_title'), $result);
    }

    public function status(Request $request)
    {
        $this->garage->status($request);
    }

    public function addEdit(Request $request)
    {
        $user_type = checkIfUserIsStandardUser();
        if($user_type) {
            return redirect()->route('admin-dashboard');
        }

        $nav = 'garage';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $data['title'] = $page_title = ($id == 0) ? "Add Garage" : "Edit Garage";
        $data['action'] = route('admin-garage-addaction');
        $data['row'] = Garage::where('id', $id)->first();
        return view('admin.garage.add', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function addAction(GarageRequest $request)
    {
        return $this->garage->store($request->validated());
    }

    public function delete(Request $request)
    {
        echo $this->garage->delete($request);
    }
}
