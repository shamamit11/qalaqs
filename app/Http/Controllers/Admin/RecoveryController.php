<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RecoveryRequest;
use App\Services\Admin\RecoveryService;
use Illuminate\Http\Request;
use App\Models\Recovery;

class RecoveryController extends Controller
{
    protected $recovery;

    public function __construct(RecoveryService $RecoveryService)
    {
        $this->recovery = $RecoveryService;
    }

    public function index(Request $request)
    {
        $user_type = checkIfUserIsStandardUser();
        if($user_type) {
            return redirect()->route('admin-dashboard');
        }

        $nav = 'recovery';
        $sub_nav = '';
        $per_page = 100;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $page_title = 'Garages';
        $result = $this->recovery->list($per_page, $page, $q);
        return view('admin.recovery.index', compact('nav', 'sub_nav', 'page_title'), $result);
    }

    public function status(Request $request)
    {
        $this->recovery->status($request);
    }

    public function addEdit(Request $request)
    {
        $user_type = checkIfUserIsStandardUser();
        if($user_type) {
            return redirect()->route('admin-dashboard');
        }

        $nav = 'recovery';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $data['title'] = $page_title = ($id == 0) ? "Add Recovery" : "Edit Recovery";
        $data['action'] = route('admin-recovery-addaction');
        $data['row'] = Recovery::where('id', $id)->first();
        return view('admin.recovery.add', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function addAction(RecoveryRequest $request)
    {
        return $this->recovery->store($request->validated());
    }

    public function delete(Request $request)
    {
        echo $this->recovery->delete($request);
    }
}
