<?php
namespace App\Services\Api\User;

use App\Models\Address;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AddressService
{
    public function addAddress($request) {
        try {
            $address = new Address();
            $address->user_id  = Auth::guard('user-api')->id();
            $address->name =  $request['name'];
            $address->building_name = $request['building_name'];
            $address->street_name = $request['street_name'];
            $address->city = $request['city'];
            $address->country = $request['country'];
            $address->mobile_no = $request['mobile_no'];
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
            $address = Address::where('user_id', $user_id)->orderBy('name', 'asc')->get();
            if ($address->count() > 0) {
                foreach ($address as $value) {
                    $address_data[] = [ 'id' => $value->id,
                                       'name' => $value->name,
                                       'building_name' => $value->building_name,
                                       'street_name' => $value->street_name,
                                       'city' => $value->city,
                                       'country' => $value->country,
                                       'mobile_no' => $value->mobile_no,
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
