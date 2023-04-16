<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Vendor\Account\UpdatePasswordRequest;
use App\Http\Requests\Api\Vendor\Account\UpdateProfileRequest;
use App\Http\Requests\Api\Vendor\Account\BankRequest;
use App\Services\Api\Vendor\AccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    protected $account;

    public function __construct(AccountService $AccountService)
    {
        $this->account = $AccountService;
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        return $this->account->updateProfile($request->validated());
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        return $this->account->updatePassword($request->validated());
    }

    public function logout()
    {
        return $this->account->logout();
    }

    public function cancelAccount()
    {
        return $this->account->cancelAccount();
    }

    public function getBankDetail() {
        return $this->account->getBankDetail();
    }
    
    public function updateBank(BankRequest $request)
    {
        return $this->account->updateBank($request->validated());
    }

    public function updatePushToken(Request $request)
    {
        return $this->account->updatePushToken($request);
    }

    public function updateProfileImage(Request $request) {
        return $this->account->updateProfileImage($request);
    }

}
