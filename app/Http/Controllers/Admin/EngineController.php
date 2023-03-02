<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EngineRequest;
use App\Services\Admin\EngineService;
use Illuminate\Http\Request;

use App\Models\Engine;
use App\Models\Make;
use App\Models\Models;
use App\Models\Year;

class EngineController extends Controller
{
    protected $engine;

    public function __construct(EngineService $EngineService)
    {
        $this->engine = $EngineService;
    }

    public function index(Request $request)
    {
        $nav = 'engine';
        $sub_nav = '';
        $per_page = 10;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $page_title = ' Engines';
        $result = $this->engine->List($per_page, $page, $q);
        return view('admin.engine.index', compact('nav', 'sub_nav', 'page_title'), $result);
    }

    public function status(Request $request)
    {
        $this->engine->status($request);
    }

    public function addEdit(Request $request)
    {
        $nav = 'engine';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $page_title = ' Engines';
        $data['title'] = ($id == 0) ? "Add Engine" : "Edit Engine";
        $data['action'] = route('admin-engine-addaction');
        $data['makes'] = Make::where('status', 1)->orderBy('name', 'asc')->get();
        $data['models'] = Models::where('status', 1)->orderBy('name', 'asc')->get();
        $data['years'] = Year::where('status', 1)->orderBy('name', 'asc')->get();
        $data['row'] = Engine::where('id', $id)->first();
        return view('admin.engine.add', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function addAction(EngineRequest $request)
    {
        return $this->engine->store($request->validated());
    }

    public function delete(Request $request)
    {
        return $this->engine->delete($request);
    }
    
}
