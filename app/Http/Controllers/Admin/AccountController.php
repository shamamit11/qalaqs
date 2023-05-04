<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileRequest;
use App\Http\Requests\Admin\ChangePasswordRequest;
use App\Http\Requests\Admin\SystemUserRequest;
use App\Models\Admin;
use App\Services\Admin\AccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    protected $account;

    public function __construct(AccountService $AccountService)
    {
        $this->account = $AccountService;

        // $this->middleware(function ($request, $next) {
        //     $user = Auth::guard('admin')->user();
        //     if($user->user_type == 'A') {
        //         redirect()->route('dashboard');
        //     }
        // });
    }
    public function index()
    {
        $nav = 'account';
        $sub_nav = '';
        $page_title = 'My Account';
		$data['user'] = Auth::guard('admin')->user();
        return view('admin.account.index', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function addAction(ProfileRequest $request)
    {
        return $this->account->addAction($request->validated());
    }

    public function changePassword()
    {
        $nav = 'account';
        $sub_nav = '';
        $page_title = "Change Password";
        return view('admin.account.change_password', compact('nav', 'sub_nav', 'page_title'));
    }
    
    public function updatePassword(ChangePasswordRequest $request)
    {
        return $this->account->updatePassword($request->validated());
    }

    public function systemUsers(Request $request)
    {
        $user_type = checkIfUserIsStandardUser();
        if($user_type) {
            return redirect()->route('admin-dashboard');
        }

        $nav = 'systemuser';
        $sub_nav = '';
        $page_title = 'System Users';
        $per_page = 100;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $result = $this->account->listUsers($per_page, $page, $q);
        return view('admin.systemuser.index', compact('nav', 'sub_nav', 'page_title'), $result);
    }

    public function systemUserAdd(Request $request)
    {
        $user_type = checkIfUserIsStandardUser();
        if($user_type) {
            return redirect()->route('admin-dashboard');
        }

        $nav = 'systemuser';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $data['title'] = $page_title = ($id == 0) ? "Add User" : "Edit User";
        $data['action'] = route('admin-systemuser-addaction');
        $data['row'] = Admin::where('id', $id)->first();
        return view('admin.systemuser.add', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function systemUserAddAction(SystemUserRequest $request)
    {
        return $this->account->systemUserAdd($request->validated());
    }

    public function systemUserStatus(Request $request)
    {
        $this->account->updateUserStatus($request);
    }

    public function deleteUser(Request $request)
    {
        return $this->account->deleteUser($request);
    }

}
