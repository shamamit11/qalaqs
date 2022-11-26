<?php
namespace App\Services\Admin;

use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function checkLogin($request)
    {
        try {
            $check_data = array('email' => $request['email'], 'password' => $request['password']);
            $remember_me = isset($request['remember_me']) ? true : false;
            if (Auth::guard('admin')->attempt($check_data, $remember_me)) {
                $response['data'] = true;
                $response['errors'] = false;
                $response['status_code'] = 200;
                return response()->json($response, 200);
            } else {
                $response['data'] = false;
                $response['errors'] = false;
                $response['status_code'] = 401;
                return response()->json($response, 401);
            }
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 401);
        }

    }
}