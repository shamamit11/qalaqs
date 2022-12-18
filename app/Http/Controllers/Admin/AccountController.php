<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileRequest;
use App\Http\Requests\Admin\ChangePasswordRequest;
use App\Services\Admin\AccountService;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    protected $account;

    public function __construct(AccountService $AccountService)
    {
        $this->account = $AccountService;
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

}
