<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ModelsRequest;
use App\Services\Admin\ModelsService;
use Illuminate\Http\Request;

use App\Models\Make;
use App\Models\Models;

class ModelsController extends Controller
{
    protected $model;

    public function __construct(ModelsService $ModelsService)
    {
        $this->model = $ModelsService;
    }

    public function index(Request $request)
    {
        $nav = 'model';
        $sub_nav = '';
        $per_page = 10;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $page_title = ' Models';
        $result = $this->model->List($per_page, $page, $q);
        return view('admin.model.index', compact('nav', 'sub_nav', 'page_title'), $result);
    }

    public function status(Request $request)
    {
        $this->model->status($request);
    }

    public function addEdit(Request $request)
    {
        $nav = 'model';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $page_title = ' Models';
        $data['title'] = ($id == 0) ? "Add Model" : "Edit Model";
        $data['action'] = route('admin-model-addaction');
        $data['makes'] = Make::where('status', 1)->orderBy('name', 'asc')->get();
        $data['row'] = Models::where('id', $id)->first();
        return view('admin.model.add', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function addAction(ModelsRequest $request)
    {
        return $this->model->store($request->validated());
    }

    public function delete(Request $request)
    {
        return $this->model->delete($request);
    }
    
}
