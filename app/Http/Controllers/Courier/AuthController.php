<?php

namespace App\Http\Controllers\Courier;

use App\Http\Controllers\Controller;
use App\Http\Requests\Courier\AuthRequest;
use App\Http\Requests\Courier\ChangePasswordRequest;
use App\Http\Requests\Courier\ForgotPasswordRequest;
use App\Http\Requests\Courier\ResetPasswordRequest;
use App\Services\Courier\AuthService;
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
        $page_title = 'Courier Login';
        $isLoggedIn = Auth::guard('courier')->user();
        if($isLoggedIn) {
            return redirect(route('courier-dashboard'));
        }
        return view('courier.auth.login', compact('page_title'));
    }

    public function checkLogin(AuthRequest $request)
    {
        return $this->auth->checkLogin($request->validated());
    }

    public function forgotPassword()
    {
        $page_title = 'Forgot Password';
        return view('courier.auth.forgot_password', compact('page_title'));
    }

    public function forgetPassword(ForgotPasswordRequest $request)
    {
        return $this->auth->forgetPassword($request->validated());
    }

    public function resetPassword($token)
    {
        $page_title = 'Reset Password';
        return view('courier.auth.reset_password', compact('page_title', 'token'));
    }

    public function savePassword(ResetPasswordRequest $request)
    {
        return $this->auth->savePassword($request->validated());
    }

    public function changePassword()
    {
        $nav = 'setting';
        $sub_nav = '';
        $page_title = "Change Password";
        $data['action'] = route('courier-password');
        return view('courier.auth.change_password', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function logout()
    {
        Auth::guard('courier')->logout();
        return redirect(route('courier-login'));
    }

    // public function updatePassword(ChangePasswordRequest $request)
    // {
    //     $message = $this->auth->updatePassword($request->validated());
    //     if ($message == 'success') {
    //         return back()->withMessage('Password changed successfully!');
    //     } else {
    //         return back()->withErrors(['error' => "Old Password Doesn't match!"]);
    //     }

    // }

}
