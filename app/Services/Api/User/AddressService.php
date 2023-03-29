<?php
namespace App\Services\Api\User;

use App\Models\UserAddress;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AddressService
{
    public function addAddress($request) {
        try {
            $address = new UserAddress();
            $address->user_id  = Auth::guard('user-api')->id();
            $address->name =  $request['name'];
            $address->building = $request['building'];
            $address->street_name = $request['street_name'];
            $address->city = $request['city'];
            $address->country = $request['country'];
            $address->mobile = $request['mobile'];
            $address->is_default = $request['is_default'];
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

    public function list() {
        try {
            $user_id = Auth::guard('user-api')->id();
            $address_data = array();
            $address = UserAddress::where('user_id', $user_id)->orderBy('name', 'asc')->get();
            if ($address->count() > 0) {
                foreach ($address as $value) {
                    $address_data[] = [ 'id' => $value->id,
                                       'name' => $value->name,
                                       'building' => $value->building,
                                       'street_name' => $value->street_name,
                                       'city' => $value->city,
                                       'country' => $value->country,
                                       'mobile' => $value->mobile,
                                       'is_default' => $value->is_default,
                        ];
                }
            }
            $response['data'] = $address_data;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}
