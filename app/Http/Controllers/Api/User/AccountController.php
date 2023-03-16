<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Account\UpdatePasswordRequest;
use App\Http\Requests\Api\User\Account\UpdateProfileRequest;
use App\Services\Api\User\AccountService;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    protected $auth;

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

}