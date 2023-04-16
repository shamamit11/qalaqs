<?php
namespace App\Services\Api\Vendor;

use App\Models\Bank;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Traits\StoreImageTrait;

class AccountService
{
    use StoreImageTrait;
    
    public function updateProfile($request)
    {
        try {
            $id = Auth::guard('vendor-api')->id();
            $vendor = Vendor::findOrFail($id);
            $vendor->business_name = $request['business_name'];
            $vendor->first_name = $request['first_name'];
            $vendor->last_name = $request['last_name'];
            $vendor->address = $request['address'];
            $vendor->city = $request['city'];
            $vendor->mobile = $request['mobile'];
            $vendor->save();
            $response['data'] = $vendor;
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function updateProfileImage($request)
    {
        try {
            $id = Auth::guard('vendor-api')->user()->id;
            $vendor = Vendor::where('id', $id)->first();
            Storage::disk('public')->delete('/vendor/' . $vendor->image);

            $vendor->image = isset($request['image']) ? $this->StoreImage($request['image'], '/vendor/') : null;
            $vendor->save();

            $response['message'] = 'Success';
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        }
        catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        } 
    }

    public function updatePassword($request)
    {
        try {
            if (Hash::check($request['old_password'], Auth::guard('vendor-api')->user()->password)) {
                Vendor::whereId(Auth::guard('vendor-api')->id())->update([
                    'password' => Hash::make($request['new_password']),
                ]);
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

    public function logout()
    {
        try {
            $tokens = Auth::guard('vendor-api')->user()->tokens;
            if ($tokens) {
                foreach ($tokens as $token) {
                    $token->revoke();
                }
            }
            Auth::guard('vendor-api')->logout(true);
            $response['message'] = __('logout');
            $response['errors'] = null;
            $response['status_code'] = 200;

            return response()->json($response, 200);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function updatePushToken($request)
    {
        $id = Auth::guard('vendor-api')->user()->id;
        $vendor = Vendor::where('id', $id)->first();
        $vendor->device_id = $request['device_id'];
        $vendor->save();
        $response['message'] = 'Success';
        $response['errors'] = false;
        $response['status_code'] = 200;
        return response()->json($response, 200);
    }

    public function cancelAccount()
    {
        try {
            $id = Auth::guard('vendor-api')->user()->id;
            $vendor = Vendor::findOrFail($id);
            if($vendor) {
                $vendor->delete();
            }
            $response['message'] = 'Success';
            $response['errors'] = false;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }  
    }

    public function getBankDetail() {
        try {
            $id = Auth::guard('vendor-api')->user()->id;
            $bank = Bank::where('vendor_id', $id)->first();
            $response['data'] = $bank;
            $response['errors'] = false;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } 
        catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }  
    }

    public function updateBank($request)
    {
        try {
            $id = Auth::guard('vendor-api')->user()->id;
            $bank = Bank::where('vendor_id', $id)->first();

            if($bank) {
                $bank = Bank::where('vendor_id', $id)->first();
            } else {
                $bank = new Bank;
            }

            $bank->vendor_id = $id;
            $bank->bank_name = $request['bank_name'];
            $bank->account_name = $request['account_name'];
            $bank->account_no = $request['account_no'];
            $bank->iban = $request['iban'];
            $bank->save();
            
            $response['data'] = $bank;
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        } 
        catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }  
    }

}
