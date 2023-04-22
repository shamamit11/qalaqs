<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Vendor\Auth\LoginRequest;
use App\Http\Requests\Api\Vendor\Auth\RegisterVendorRequest;
use App\Http\Requests\Api\Vendor\Auth\ResetPasswordRequest;
use App\Http\Requests\Api\Vendor\Auth\ForgotPasswordRequest;
use App\Services\Api\Vendor\AuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $auth;

    public function __construct(AuthService $AuthService)
    {
        $this->auth = $AuthService;
    }

    public function registerVendor(RegisterVendorRequest $request)
    {
        return $this->auth->registerVendor($request->validated());
    }
    

    public function checkLogin(LoginRequest $request)
    {
        return $this->auth->checkLogin($request->validated());
    }

    public function refreshToken()
    {
        return $this->auth->refreshToken();
    }

    public function forgetPassword(ForgotPasswordRequest $request)
    {
        return $this->auth->forgotPassword($request);
    }

    public function resetPassword(ResetPasswordRequest $request) {
        return $this->auth->resetPassword($request);
    }

  

}
