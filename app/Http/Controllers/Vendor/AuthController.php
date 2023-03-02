<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\Auth\LoginRequest;
use App\Services\Vendor\AuthService;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $auth;

    public function __construct(AuthService $AuthService)
    {
        $this->auth = $AuthService;
    }

    public function checkLogin(LoginRequest $request)
    {
        return $this->auth->checkLogin($request->validated());
    }

    public function refreshToken()
    {
        return $this->auth->refreshToken();
    }

    public function logout()
    {
        return $this->auth->logout();
    }

}
