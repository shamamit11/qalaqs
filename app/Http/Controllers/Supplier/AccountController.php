<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\ProfileRequest;
use App\Http\Requests\Supplier\ChangePasswordRequest;
use App\Models\Country;
use App\Services\Supplier\AccountService;
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
        $data['countries'] = Country::get();
		$data['user'] = Auth::guard('supplier')->user();
        return view('supplier.account.index', compact('nav', 'sub_nav', 'page_title'), $data);
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
        return view('supplier.account.change_password', compact('nav', 'sub_nav', 'page_title'));
    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        return $this->account->updatePassword($request->validated());
    }

}
