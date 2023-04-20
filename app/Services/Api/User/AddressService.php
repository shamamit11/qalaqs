<?php
namespace App\Services\Api\User;

use App\Models\UserAddress;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AddressService
{

    public function list() {
        try {
            $user_id = Auth::guard('user-api')->id();
            $address = UserAddress::where('user_id', $user_id)->orderBy('name', 'asc')->get();
            $response['data'] = $address;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
    public function addEdit($request) {
        try {
            if ($request['id']) {
                $id = $request['id'];
                $address = UserAddress::findOrFail($id);
            } else {
                $address = new UserAddress();
            }
            $address->user_id  = Auth::guard('user-api')->id();
            $address->name =  $request['name'];
            $address->building = $request['building'];
            $address->street_name = $request['street_name'];
            $address->city = $request['city'];
            $address->country = $request['country'];
            $address->mobile = $request['mobile'];
            $address->is_default = isset($request['is_default']) ? $request['is_default'] : '';
            $address->save();
            $response['data'] = true;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function getAddress($id) {
        try {
            $user_id = Auth::guard('user-api')->id();
            $address = UserAddress::where([['user_id', $user_id], ['id', $id]])->first();
            $response['data'] = $address;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function deleteAddress($id) {
        try {
            $user_id = Auth::guard('user-api')->id();
            $address = UserAddress::where([['user_id', $user_id], ['id', $id]])->first();
            $address->delete();
            $response['message'] = "success";
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    
}
