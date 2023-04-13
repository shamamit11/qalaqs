<?php
namespace App\Services\Vendor;

use App\Models\Bank;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\StoreImageTrait;
use Illuminate\Support\Facades\Storage;


class AccountService
{
    use StoreImageTrait;
    public function addAction($request)
    {
        try {
            $id = Auth::guard('vendor')->id();
            $vendor = Vendor::findOrFail($id);
            $vendor->business_name = $request['business_name'];
            $vendor->first_name = $request['first_name'];
            $vendor->last_name = $request['last_name'];
            $vendor->mobile = $request['mobile'];
            $vendor->address = $request['address'];
            $vendor->city = $request['city'];

            if (preg_match('#^data:image.*?base64,#', $request['image'])) {
                $profile_image = $this->StoreBase64Image($request['image'], '/vendor/');
            } else {
                $profile_image = ($vendor) ? $vendor->image : '';
            }

            $vendor->image = $profile_image;
            $vendor->save();
            $response['data'] = $vendor;
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function updatePassword($request)
    {
        try {
            if (Hash::check($request['old_password'], Auth::guard('vendor')->user()->password)) {
                Vendor::whereId(Auth::guard('vendor')->id())->update([
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

    public function imageDelete($request) {
        try {
            $id = Auth::guard('vendor')->id();
            $field_name = $request->field_name;
            $ras = Vendor::where('id', $id)->first();
            if ($ras) {
                Storage::disk('public')->delete('/vendor/' . $ras->$field_name);
                $ras->$field_name = '';
                $ras->save();
            }
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 401);
        }
    }

    public function updateBank($request)
    {
        try {
            $vendor_id = Auth::guard('vendor')->id();
            $bank = Bank::where('vendor_id', $vendor_id)->first();

            if($bank) {
                $bank = Bank::where('vendor_id', $vendor_id)->first();
            } else {
                $bank = new Bank;
            }

            $bank->vendor_id = $vendor_id;
            $bank->bank_name = $request['bank_name'];
            $bank->account_name = $request['account_name'];
            $bank->account_no = $request['account_no'];
            $bank->iban = $request['iban'];
            $bank->save();

            $response['data'] = $bank;
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

}
