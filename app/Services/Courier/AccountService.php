<?php
namespace App\Services\Courier;

use App\Models\Bank;
use App\Models\Courier;
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
            $id = Auth::guard('courier')->id();
            $courier = Courier::findOrFail($id);
            $courier->business_name = $request['business_name'];
            $courier->first_name = $request['first_name'];
            $courier->last_name = $request['last_name'];
            $courier->mobile = $request['mobile'];
            $courier->address = $request['address'];
            $courier->city = $request['city'];

            if (preg_match('#^data:image.*?base64,#', $request['image'])) {
                $profile_image = $this->StoreBase64Image($request['image'], '/courier/');
            } else {
                $profile_image = ($courier) ? $courier->image : '';
            }

            $courier->image = $profile_image;
            $courier->save();
            $response['data'] = $courier;
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
            if (Hash::check($request['old_password'], Auth::guard('courier')->user()->password)) {
                Courier::whereId(Auth::guard('courier')->id())->update([
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
            $id = Auth::guard('courier')->id();
            $field_name = $request->field_name;
            $ras = Courier::where('id', $id)->first();
            if ($ras) {
                Storage::disk('public')->delete('/courier/' . $ras->$field_name);
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
            $courier_id = Auth::guard('courier')->id();
            $bank = Bank::where('courier_id', $courier_id)->first();

            if($bank) {
                $bank = Bank::where('courier_id', $courier_id)->first();
            } else {
                $bank = new Bank;
            }

            $bank->courier_id = $courier_id;
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
