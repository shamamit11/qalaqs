<?php
namespace App\Services\Site;

use App\Models\Courier;
use App\Models\Vendor;
use App\Models\User;

class CommonService
{
    public function verifyVendorAccount($token)
    {
        try {
            $decoded_token = decode_param($token);
            $vendor = Vendor::where('vendor_code', $decoded_token)->first();

            if($vendor) {
                $vendor->status = 1;
                $vendor->admin_approved = 1;
                $vendor->email_verified = 1;
                $vendor->save();
                return redirect()->route('account-verified');
            }
            else {
                return redirect()->route('account-not-verified');
            }
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function verifyUserAccount($token)
    {
        try {
            $decoded_token = decode_param($token);
            $user = User::where('user_code', $decoded_token)->first();
            if($user) {
                $user->status = 1;
                $user->email_verified = 1;
                $user->save();
                return redirect()->route('account-verified');
            }
            else {
                return redirect()->route('account-not-verified');
            }
           
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function verifyCourierAccount($token, $code)
    {
        try {
            $decoded_token = decode_param($token);
            $decoded_code = decode_param($code);
            $courier = Courier::where([['courier_code', $decoded_code], ['verification_code', $decoded_token]])->first();

            if($courier) {
                $courier->verification_code = '';
                $courier->status = 1;
                $courier->is_deleted = 0;
                $courier->email_verified = 1;
                $courier->save();
                return redirect()->route('account-verified');
            }
            else {
                return redirect()->route('account-not-verified');
            }
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

}
