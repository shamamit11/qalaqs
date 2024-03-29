<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Account\UpdatePasswordRequest;
use App\Http\Requests\Api\User\Account\UpdateProfileRequest;
use App\Services\Api\User\AccountService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $account;

    public function __construct(AccountService $AccountService)
    {
        $this->account = $AccountService;
    }

    public function getProfile()
    {
        return $this->account->getProfile();
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        return $this->account->updateProfile($request->validated());
    }

    public function updateProfileImage(Request $request)
    {
        return $this->account->updateProfileImage($request);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        return $this->account->updatePassword($request->validated());
    }

    public function updatePushToken(Request $request)
    {
        return $this->account->updatePushToken($request);
    }

    public function logout()
    {
        return $this->account->logout();
    }

    public function cancelAccount()
    {
        return $this->account->cancelAccount();
    }

    public function notification() {
        return $this->account->notification();
    }

    public function updateNotificationStatus(Request $request) {
        return $this->account->updateNotificationStatus($request);
    }


}