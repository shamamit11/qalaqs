<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\AuthRequest;
use App\Http\Requests\Vendor\ChangePasswordRequest;
use App\Http\Requests\Vendor\ForgotPasswordRequest;
use App\Http\Requests\Vendor\ResetPasswordRequest;
use App\Services\Vendor\AuthService;
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
        $page_title = 'Vendor Login';
        return view('vendor.auth.login', compact('page_title'));
    }

    public function checkLogin(AuthRequest $request)
    {
        return $this->auth->checkLogin($request->validated());
    }

    public function forgotPassword()
    {
        $page_title = 'Forgot Password';
        return view('vendor.auth.forgot_password', compact('page_title'));
    }

    public function forgetPassword(ForgotPasswordRequest $request)
    {
        return $this->auth->forgetPassword($request->validated());
    }

    public function resetPassword($token)
    {
        $page_title = 'Reset Password';
        return view('vendor.auth.reset_password', compact('page_title', 'token'));
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
        $data['action'] = route('vendor-password');
        return view('vendor.auth.change_password', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function logout()
    {
        Auth::guard('vendor')->logout();
        return redirect(route('vendor-login'));
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
