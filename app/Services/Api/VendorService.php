<?php
namespace App\Services\Api;

use App\Models\Vendor;
use Illuminate\Support\Facades\Storage;

class VendorService
{
    public function store($request) {
        try {
            $vendor = new Vendor();
            $vendor->account_type =  $request['account_type'];
            $vendor->business_name = $request['business_name'];
            $vendor->first_name = $request['first_name'];
            $vendor->last_name = $request['last_name'];
            $vendor->mobile = $request['mobile'];
            $vendor->email = $request['email'];
            $vendor->password =bcrypt($request['password']);
            if (preg_match('#^data:image.*?base64,#', $request['license_image'])) {
                $image = $this->StoreBase64Image($request['license_image'], '/vendor/');
            } else {
                $image = ($vendor) ? $vendor->license_image : '';
            }
            $vendor->license_image = $image;
            $vendor->save();

            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 201);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    
}
