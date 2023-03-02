<?php
namespace App\Services\Vendor;

use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountService
{
    public function addAction($request)
    {
        try {
            $id = Auth::guard('vendor')->id();
            $vendor = Vendor::findOrFail($id);
            $vendor->name = $request['name'];
            $vendor->address = $request['address'];
            $vendor->city = $request['city'];
            $vendor->state = $request['state'];
            $vendor->zipcode = $request['zipcode'];
            $vendor->phone = $request['phone'];
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

}
