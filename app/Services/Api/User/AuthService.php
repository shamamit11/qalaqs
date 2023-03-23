<?php
namespace App\Services\Api\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Traits\StoreImageTrait;

class AuthService
{
    use StoreImageTrait;
    public function registerUser($request) {
        try {
            $user = new User();
            $user->user_type =  $request['user_type'];
            $user->business_name = $request['business_name'];
            $user->first_name = $request['first_name'];
            $user->last_name = $request['last_name'];
            $user->mobile = $request['mobile'];
            $user->email = $request['email'];
            $user->password =  Hash::make($request['password']);
//            $user->verification_code = '12345';
            $user->save();
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function checkLogin($request)
    {
        try {
            $credentials = array('email' => $request['email'], 'password' => $request['password']);
            $token = Auth::guard('user-api')->attempt($credentials);
            if ($token) {
                $response['data'] = array('id' => Auth::guard('user-api')->user()->id, 'first_name' => Auth::guard('user-api')->user()->first_name, 'last_name' => Auth::guard('user-api')->user()->last_name, 'token' => $token);
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
            $refresh_token = Auth::guard('user-api')->refresh();
            $response['data'] = $refresh_token;
            $response['message'] = __('fresh token');
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

}