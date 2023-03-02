<?php
namespace App\Services\Vendor;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{

    public function checkLogin($request)
    {
        try {
            $credentials = array('email' => $request['email'], 'password' => $request['password']);
            $token = Auth::guard('vendor')->attempt($credentials);
            if ($token) {
                $response['data'] = array('id' => Auth::guard('vendor')->user()->id, 'first_name' => Auth::guard('vendor')->user()->first_name, 'last_name' => Auth::guard('vendor')->user()->last_name, 'token' => $token);
                $response['errors'] = false;
                $response['status_code'] = 200;
                return response()->json($response, 200);
            } else {
                $response['data'] = false;
                $response['errors'] = false;
                $response['status_code'] = 406;
                return response()->json($response, 406);
            }
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function refreshToken()
    {
        try {
            $refresh_token = Auth::guard('vendor')->refresh();
            $response['data'] = $refresh_token;
            $response['message'] = __('fresh token');
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function logout()
    {
        try {
            $tokens = Auth::guard('vendor')->user()->tokens;
            if ($tokens) {
                foreach ($tokens as $token) {
                    $token->revoke();
                }
            }
            Auth::guard('vendor')->logout(true);
            $response['message'] = __('logout');
            $response['errors'] = null;
            $response['status_code'] = 200;

            return response()->json($response, 200);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

}