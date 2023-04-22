<?php
namespace App\Services\Api\User;

use App\Models\User;
use DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\StoreImageTrait;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    use StoreImageTrait;
    public function registerUser($request) {
        try {
            $user = new User();
            $user->user_type =  $request['user_type'];
            $user->business_name = isset($request['business_name']) ? $request['business_name'] : null;;
            $user->first_name = $request['first_name'];
            $user->last_name = $request['last_name'];
            $user->mobile = $request['mobile'];
            $user->email = $request['email'];
            $user->password =  Hash::make($request['password']);
            $user->device_id = isset($request['device_id']) ? $request['device_id'] : null;
            $user->status = 1;
            $user->is_deleted = 0;
            $user->save();
            $response['data'] = $user;
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
            $credentials = array('email' => $request['email'], 'password' => $request['password'], 'is_deleted' => 0, 'status' => 1);
            $token = Auth::guard('user-api')->attempt($credentials);
            if ($token) {
                $user = array('id' => Auth::guard('user-api')->user()->id);
                $accesstoken = Auth::guard('user-api')->claims($user)->attempt($credentials);
                $response['data'] = array('id' => Auth::guard('user-api')->user()->id, 'first_name' => Auth::guard('user-api')->user()->first_name, 'last_name' => Auth::guard('user-api')->user()->last_name, 'token' => $accesstoken);
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

    public function forgotPassword($request) {
        try {
            $user = User::where('email', $request['email'])->first();
            $user_first_name = $user->first_name;
            $token = random_int(1000, 9999);

            $checkIfTokenExists = DB::table('password_reset_tokens')->where('email', $request['email'])->first();

            if($checkIfTokenExists) {
                DB::table('password_reset_tokens')->where('email', $request['email'])->delete();
            }

            DB::table('password_reset_tokens')->insert([
                'email' => $request['email'],
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);

            Mail::send('email.user.forgot_password', ['token' => $token, 'name' => $user_first_name], function ($message) use ($request) {
                $message->to($request['email']);
                $message->subject('Reset Password Code from Qalaqs');
            });

            $response['message'] = "success";
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        }
        catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function resetPassword($request)
    {
        try {
            $updatePassword = DB::table('password_reset_tokens')->where([['email', $request['email']], ['token', $request['token']]])->first();
            
            if ($updatePassword) {
                User::where('email', $updatePassword->email)->update(['password' => Hash::make($request['new_password'])]);
                DB::table('password_reset_tokens')->where(array('email' => $updatePassword->email, 'token' => $updatePassword->token))->delete();
                $response['data'] = true;
                $response['errors'] = false;
                $response['status_code'] = 200;
                return response()->json($response, 200);
            } 
            else {
                $response['data'] = false;
                $response['errors'] = false;
                $response['status_code'] = 401;
                return response()->json($response, 401);
            }
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

}