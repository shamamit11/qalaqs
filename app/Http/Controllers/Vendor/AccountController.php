<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\BankRequest;
use App\Http\Requests\Vendor\ProfileRequest;
use App\Http\Requests\Vendor\ChangePasswordRequest;
use App\Models\Bank;
use App\Services\Vendor\AccountService;
use Illuminate\Http\Request;
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
		$data['user'] = Auth::guard('vendor')->user();
        return view('vendor.account.index', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function imageDelete(Request $request) {
        echo $this->account->imageDelete($request);
    }

    public function addAction(ProfileRequest $request)
    {
        return $this->account->addAction($request->validated());
    }

    public function changePassword()
    {
        $nav = 'password';
        $sub_nav = '';
        $page_title = "Change Password";
        return view('vendor.account.change_password', compact('nav', 'sub_nav', 'page_title'));
    }
    
    public function updatePassword(ChangePasswordRequest $request)
    {
        return $this->account->updatePassword($request->validated());
    }

    public function bank()
    {
        $nav = 'bank';
        $sub_nav = '';
        $page_title = "Bank Information";
        $vendor_id = Auth::guard('vendor')->id();
        $data['row'] = Bank::where('vendor_id', $vendor_id)->first();
        return view('vendor.account.bank', compact('nav', 'sub_nav', 'page_title'), $data);
    }
    
    public function updateBank(BankRequest $request)
    {
        return $this->account->updateBank($request->validated());
    }

    public function bankImageDelete(Request $request) {
        echo $this->account->bankImageDelete($request);
    }

}
