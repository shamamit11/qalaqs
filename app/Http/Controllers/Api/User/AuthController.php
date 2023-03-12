<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Auth\LoginRequest;
use App\Http\Requests\Api\User\Auth\RegisterUserRequest;
use App\Services\Api\User\AuthService;
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

    public function registerUser(RegisterUserRequest $request)
    {
        return $this->auth->registerUser($request->validated());
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
