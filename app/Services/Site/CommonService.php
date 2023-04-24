<?php
namespace App\Services\Site;

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

}
