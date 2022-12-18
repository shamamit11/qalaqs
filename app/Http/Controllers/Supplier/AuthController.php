<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\AuthRequest;
use App\Http\Requests\Supplier\RegisterRequest;
use App\Http\Requests\Supplier\VerifyRequest;
use App\Http\Requests\Supplier\ChangePasswordRequest;
use App\Http\Requests\Supplier\ForgotPasswordRequest;
use App\Http\Requests\Supplier\ResetPasswordRequest;
use App\Models\Country;
use App\Services\Supplier\AuthService;
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
        $page_title = 'Dashboard';
        return view('supplier.auth.login', compact('page_title'));
    }

    public function checkLogin(AuthRequest $request)
    {
        return $this->auth->checkLogin($request->validated());
    }

    public function register()
    {
        $page_title = 'Register';
        $data['countries'] = Country::get();
        return view('supplier.auth.register', compact('page_title'), $data);
    }

    public function registerSupplier(RegisterRequest $request)
    {
        return $this->auth->registerSupplier($request->validated());
    }

    public function verify($email)
    {
        $page_title = 'Verify';
        $data['email'] = $email;
        return view('supplier.auth.verify', compact('page_title'), $data);
    }

    public function verifySupplier(VerifyRequest $request)
    {
        return $this->auth->verifySupplier($request->validated());
    }

    public function forgotPassword()
    {
        $page_title = 'Forgot Password';
        return view('supplier.auth.forgot_password', compact('page_title'));
    }

    public function forgetPassword(ForgotPasswordRequest $request)
    {
        return $this->auth->forgetPassword($request->validated());
    }

    public function resetPassword($token)
    {
        $page_title = 'Reset Password';
        return view('supplier.auth.reset_password', compact('page_title', 'token'));
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
        $data['action'] = route('supplier-password');
        return view('supplier.auth.change_password', compact('nav', 'sub_nav', 'page_title'), $data);
    }
    
    public function logout()
    {
        Auth::guard('supplier')->logout();
        return redirect(route('supplier-login'));
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
