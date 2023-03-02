<?php
namespace App\Services\Supplier;

use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountService
{
    public function addAction($request)
    {
        try {
            $id = Auth::guard('supplier')->id();
            $supplier = Supplier::findOrFail($id);
            $supplier->name = $request['name'];
            $supplier->address = $request['address'];
            $supplier->city = $request['city'];
            $supplier->state = $request['state'];
            $supplier->zipcode = $request['zipcode'];
            $supplier->country_id = $request['country_id'];
            $supplier->phone = $request['phone'];
            $supplier->mobile = $request['mobile'];
            $supplier->save();
            $response['data'] = $supplier;
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
            if (Hash::check($request['old_password'], Auth::guard('supplier')->user()->password)) {
                Supplier::whereId(Auth::guard('supplier')->id())->update([
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
