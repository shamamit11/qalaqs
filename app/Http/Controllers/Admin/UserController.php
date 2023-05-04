<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Admin\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserService $UserService)
    {
        $this->user = $UserService;
    }

    public function index(Request $request)
    {
        $user_type = checkIfUserIsStandardUser();
        if($user_type) {
            return redirect()->route('admin-dashboard');
        }

        $nav = 'user';
        $sub_nav = '';
        $per_page = 100;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $page_title = 'Customers';
        $result = $this->user->list($per_page, $page, $q);
        return view('admin.users.index', compact('nav', 'sub_nav', 'page_title'), $result);
    }

    public function status(Request $request)
    {
        $this->user->status($request);
    }

    public function view(Request $request)
    {
        $user_type = checkIfUserIsStandardUser();
        if($user_type) {
            return redirect()->route('admin-dashboard');
        }

        $nav = 'user';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $page_title = 'User Details';
        $data['title'] = ($id == 0) ? "Add User" : "View User";
        $data['row'] = User::where('id', $id)->first();
        return view('admin.users.view', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function delete(Request $request)
    {
        return $this->user->delete($request);
    }
}
