<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Vendor\Auth\LoginRequest;
use App\Http\Requests\Api\Vendor\Auth\RegisterVendorRequest;
use App\Http\Requests\Api\Vendor\Auth\ResetPasswordRequest;
use App\Http\Requests\Api\Vendor\Auth\ForgotPasswordRequest;
use App\Http\Requests\Api\Vendor\Auth\UploadVendorDocRequest;
use App\Http\Requests\Api\Vendor\Auth\VendorBankInfoRequest;
use App\Http\Requests\Api\Vendor\Auth\VendorMakeRequest;
use App\Services\Api\Vendor\AuthService;
use Illuminate\Http\Request;
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

    public function uploadVendorDocs(UploadVendorDocRequest $request)
    {
        return $this->auth->uploadDocs($request->validated());
    }
    
    public function addVendorBankInfo(VendorBankInfoRequest $request)
    {
        return $this->auth->addBankInfo($request->validated());
    }

    public function addVendorMakeData(VendorMakeRequest $request)
    {
        return $this->auth->addVendorMakeData($request->validated());
    }

    public function sendEmailToVendor(Request $request)
    {
        return $this->auth->sendEmailToVendor($request);
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
