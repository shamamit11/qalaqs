<?php
namespace App\Services\Vendor;

use App\Models\Vendor;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail;

class AuthService
{
    public function checkLogin($request)
    {
        try {
            $fieldType = filter_var($request['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
            $check_data = array($fieldType => $request['email'], 'password' => $request['password'], 'status' => 1, 'admin_approved' => 1);
            // $check_data = array('email' => $request['email'], 'password' => $request['password']); 
            $remember_me = isset($request['remember_me']) ? true : false;
            if (Auth::guard('vendor')->attempt($check_data, $remember_me)) {
                session(array('user_name' => Auth::guard('vendor')->user()->name));
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
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function forgetPassword($request)
    {
        try {
            $token = Str::random(64);
            DB::table('password_resets')->insert([
                'email' => $request['email'],
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);

            Mail::send('email.vendor.forgot_password', ['token' => $token], function ($message) use ($request) {
                $message->to($request['email']);
                $message->subject('Reset Password');
            });

            $response['data'] = true;
            $response['errors'] = false;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }

    }

    public function savePassword($request)
    {
        try {
            $updatePassword = DB::table('password_resets')->where('token', $request['token'])->first();
            if ($updatePassword) {
                Vendor::where('email', $updatePassword->email)->update(['password' => Hash::make($request['new_password'])]);
                DB::table('password_resets')->where(array('email' => $updatePassword->email, 'token' => $updatePassword->token))->delete();
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
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}
