<?php
namespace App\Services\supplier;

use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mail;

class AuthService
{
    public function checkLogin($request)
    {
        $check_data = array('email' => $request['email'], 'password' => $request['password']);
        $remember_me = isset($request['remember_me']) ? true : false;
        if (Auth::guard('supplier')->attempt($check_data, $remember_me)) {
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

}
