<?php
namespace App\Services\Supplier;

use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail;
use DB;
use Session;

class AuthService
{
    public function checkLogin($request)
    {
        $check_data = array('email' => $request['email'], 'password' => $request['password']);
        $remember_me = isset($request['remember_me']) ? true : false;
        if (Auth::guard('supplier')->attempt($check_data, $remember_me)) {
            $supplier = Supplier::where('id', Auth::guard('supplier')->id())->first();
            session(['user_name' => $supplier->name,
                     'admin_approved' => $supplier->admin_approved]);
            $response['data'] = true ;
            $response['errors'] = false;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } else {
            $response['data'] = false;
            $response['errors'] = false;
            $response['status_code'] = 401;
            return response()->json($response, 401);
        }
    }

    public function registerSupplier($request)
    {
        try {
            $otp = rand(1111, 9999);
            $supplier = new Supplier;
            $supplier->supplier_code = rand(11111111, 99999999);
            $supplier->name = $request['name'];
            $supplier->address = $request['address'];
            $supplier->city = $request['city'];
            $supplier->state = $request['state'];
            $supplier->zipcode = $request['zipcode'];
            $supplier->country_id = $request['country_id'];
            $supplier->phone = $request['phone'];
            $supplier->mobile = $request['mobile'];
            $supplier->email = $request['email'];
            $supplier->password = Hash::make($request['password']);
            $supplier->verification_code = $otp;
            $supplier->save();

            $email = $request['email'];
            Mail::send('email.supplier.otp', ['otp' => $otp], function ($message) use ($email, $otp) {
                $message->to($email);
                $message->subject('Qalaqs verification code: ' . $otp);
            });

            $response['data'] = $supplier;
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);

        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 401);
        }
    }

    public function verifySupplier($request)
    {
        try {
            $supplier = Supplier::where('email', $request['email'])->first();
            if ($supplier) {
                if ($supplier->email_verified == 1) {
                    $response['data'] = $supplier;
                    $response['errors'] = false;
                    $response['status_code'] = 200;
                    return response()->json($response, 200);
                } else if ($supplier->verification_code == $request['verification_code']) {
                    $supplier->verification_code = '';
                    $supplier->email_verified = 1;
                    $supplier->save();
                    $response['data'] = $supplier;
                    $response['errors'] = false;
                    $response['status_code'] = 201;
                    return response()->json($response, 201);
                } else {
                    $response['errors'] = false;
                    $response['status_code'] = 401;
                    return response()->json($response, 201);
                }
            } else {
                $response['data'] = $supplier;
                $response['errors'] = false;
                $response['status_code'] = 401;
                return response()->json($response, 401);
            }
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 401);
        }
    }

    public function forgetPassword($request)
    {
        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $request['email'],
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        Mail::send('email.supplier.forgot_password', ['token' => $token], function ($message) use ($request) {
            $message->to($request['email']);
            $message->subject('Reset Password');
        });

        $response['data'] = true;
        $response['errors'] = false;
        $response['status_code'] = 200;
        return response()->json($response, 200);

    }

    public function savePassword($request)
    {
        $updatePassword = DB::table('password_resets')->where('token', $request['token'])->first();

        if ($updatePassword) {
            Supplier::where('email', $updatePassword->email)->update(['password' => Hash::make($request['new_password'])]);
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
    }

    // public function updatePassword($request)
    // {
    //     if (Hash::check($request['old_password'], Auth::guard('supplier')->user()->password)) {
    //         Supplier::whereId(Auth::guard('supplier')->id())->update([
    //             'password' => Hash::make($request['new_password']),
    //         ]);
    //         $response['data'] = true;
    //         $response['errors'] = false;
    //         $response['status_code'] = 200;
    //         return response()->json($response, 200);
    //         //return $message = 'success';
    //     } else {
    //         $response['data'] = false;
    //         $response['errors'] = false;
    //         $response['status_code'] = 401;
    //         return response()->json($response, 401);
    //         //return $message = 'error';
    //     }
    // }

}
