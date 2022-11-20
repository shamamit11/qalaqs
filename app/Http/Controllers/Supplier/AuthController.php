<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\AuthRequest;
use App\Http\Requests\Supplier\RegisterRequest;
use App\Http\Requests\Supplier\VerifyRequest;
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
        return view('supplier.auth.login');
    }

    public function checkLogin(AuthRequest $request)
    {
        return $this->auth->checkLogin($request->validated());
    }

    public function register()
    {
        $data['countries'] = Country::get();
        return view('supplier.auth.register', $data);
    }

    public function registerSupplier(RegisterRequest $request)
    {
        return $this->auth->registerSupplier($request->validated());
    }

    public function verify($email)
    {
        $data['email'] = $email;
        return view('supplier.auth.verify', $data);
    }

    public function verifySupplier(VerifyRequest $request)
    {
        return $this->auth->verifySupplier($request->validated());
    }

    public function logout()
    {
        Auth::guard('supplier')->logout();
        return redirect(route('supplier-login'));
    }

}
