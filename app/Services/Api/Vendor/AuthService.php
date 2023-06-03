<?php
namespace App\Services\Api\Vendor;

use App\Models\Vendor;
use DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\StoreImageTrait;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    use StoreImageTrait;
    public function registerVendor($request) {
        $date = date_create();
        try {
            $vendor = new Vendor();
            $vendor->vendor_code = date_timestamp_get($date);
            $vendor->account_type =  $request['account_type'];
            $vendor->business_name = $request['business_name'];
            $vendor->first_name = $request['first_name'];
            $vendor->last_name = $request['last_name'];
            $vendor->mobile = $request['mobile'];
            $vendor->address = $request['address'];
            $vendor->city = $request['city'];
            $vendor->email = $request['email'];
            $vendor->password =  Hash::make($request['password']);
            $vendor->image = isset($request['image']) ? $this->StoreImage($request['image'], '/vendor/') : null;
            $vendor->license_image = isset($request['license_image']) ? $this->StoreImage($request['license_image'], '/vendor/') : null;
            $vendor->device_id = isset($request['device_id']) ? $request['device_id'] : null;
            $vendor->status = 0;
            $vendor->admin_approved = 0;
            $vendor->email_verified = 0;
            $vendor->is_deleted = 0;
            $vendor->save();

            //send verification email
            $token = encode_param($vendor->vendor_code);
            $emailData = [
                'first_name' => $vendor->first_name,
                'email' => $request['email'],
                'password' => $request['password'],
                'token' => $token
            ];
            Mail::send('email.vendor.verify_account', $emailData, function ($message) use ($request) {
                $message->to($request['email']);
                $message->subject('Qalaqs: Verify Your Account');
            });

            $response['data'] = $vendor;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        } 
        catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function verifyEmail($request) {

    }

    public function checkLogin($request)
    {
        try {
            $credentials = array('email' => $request['email'], 'password' => $request['password'], 'is_deleted' => 0, 'status' => 1, 'admin_approved' => 1, 'email_verified' => 1);
            $token = Auth::guard('vendor-api')->attempt($credentials);

            if ($token) {
                $vendor = array(
                    'id' => Auth::guard('vendor-api')->user()->id,
                    'first_name' => Auth::guard('vendor-api')->user()->first_name,
                    'last_name' => Auth::guard('vendor-api')->user()->last_name,
                    'business_name' => Auth::guard('vendor-api')->user()->business_name,
                    'image' => env('APP_URL').'/storage/vendor/'.Auth::guard('vendor-api')->user()->image,
                );
                $accesstoken = Auth::guard('vendor-api')->claims($vendor)->attempt($credentials);
                $response['data'] = array('id' => Auth::guard('vendor-api')->user()->id, 'first_name' => Auth::guard('vendor-api')->user()->first_name, 'last_name' => Auth::guard('vendor-api')->user()->last_name, 'business_name' => Auth::guard('vendor-api')->user()->business_name, 'token' => $accesstoken);
                $response['errors'] = false;
                $response['status_code'] = 200;
                return response()->json($response, 200);
            } else {
                $response['data'] = false;
                $response['message'] = 'Invalid username and password';
                $response['errors'] = true;
                $response['status_code'] = 422;
                return response()->json($response, 422);
            }
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function refreshToken()
    {
        try {
            $refresh_token = Auth::guard('vendor-api')->refresh();
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
            $user = Vendor::where([['email', $request['email']], ['is_deleted', 0]])->first();
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

            Mail::send('email.vendor.forgot_password', ['token' => $token, 'name' => $user_first_name], function ($message) use ($request) {
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
                Vendor::where('email', $updatePassword->email)->update(['password' => Hash::make($request['new_password'])]);
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