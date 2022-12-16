<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AuthRequest;
use App\Http\Requests\Admin\ChangePasswordRequest;
use App\Http\Requests\Admin\ForgotPasswordRequest;
use App\Http\Requests\Admin\ResetPasswordRequest;
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
        $page_title = 'Login';
        return view('admin.auth.login', compact('page_title'));
    }

    public function checkLogin(AuthRequest $request)
    {
        return $this->auth->checkLogin($request->validated());
    }

    public function forgotPassword()
    {
        $page_title = 'Forgot Password';
        return view('admin.auth.forgot_password', compact('page_title'));
    }

    public function forgetPassword(ForgotPasswordRequest $request)
    {
        return $this->auth->forgetPassword($request->validated());
    }

    public function resetPassword($token)
    {
        $page_title = 'Reset Password';
        return view('admin.auth.reset_password', compact('page_title', 'token'));
    }

    public function savePassword(ResetPasswordRequest $request)
    {
        return $this->auth->savePassword($request->validated());
        // if ($message == 'success') {
        //     return redirect(route('admin-login'))->withMessage('Password changed successfully!');
        // } else {
        //     return back()->withErrors(['error' => "Invalid token!"]);
        // }
    }

    public function changePassword()
    {
        $nav = 'setting';
        $sub_nav = '';
        $title = "Change Password";
        $data['action'] = route('admin-password');
        return view('admin.auth.change_password', compact('nav', 'sub_nav', 'title'), $data);
    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        $message = $this->auth->updatePassword($request->validated());
        if ($message == 'success') {
            return back()->withMessage('Password changed successfully!');
        } else {
            return back()->withErrors(['error' => "Old Password Doesn't match!"]);
        }

    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect(route('admin-login'));
    }

}
