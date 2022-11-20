<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AuthRequest;
use App\Services\Admin\AuthService;
use Illuminate\Support\Facades\Auth; 

class AuthController extends Controller
{
    protected $auth;

    public function __construct(AuthService $AuthService)
    {
        $this->auth = $AuthService;
    }

    public function login()
    {
        return view('admin.auth.login');
    }

    public function checkLogin(AuthRequest $request)
    {
        return $this->auth->checkLogin($request->validated());
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect(route('admin-login'));
    }

}
