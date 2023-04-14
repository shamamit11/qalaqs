<?php
namespace App\Services\Api\Vendor;

use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\StoreImageTrait;

class AuthService
{
    use StoreImageTrait;
    public function registerVendor($request) {
        try {
            $vendor = new Vendor();
            $vendor->vendor_code = rand(11111111, 99999999);
            $vendor->account_type =  $request['account_type'];
            $vendor->business_name = $request['business_name'];
            $vendor->first_name = $request['first_name'];
            $vendor->last_name = $request['last_name'];
            $vendor->mobile = $request['mobile'];
            $vendor->email = $request['email'];
            $vendor->password =  Hash::make($request['password']);
            $vendor->image = isset($request['image']) ? $this->StoreImage($request['image'], '/vendor/') : null;
            $vendor->license_image = isset($request['license_image']) ? $this->StoreImage($request['license_image'], '/vendor/') : null;
            $vendor->device_id = isset($request['device_id']) ? $request['device_id'] : null;
            $vendor->save();
            $response['data'] = $vendor;
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

}