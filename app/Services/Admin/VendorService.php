<?php
namespace App\Services\Admin;

use App\Models\Bank;
use App\Models\Vendor;
use Illuminate\Support\Facades\Hash;
use App\Traits\StoreImageTrait;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class VendorService
{
    use StoreImageTrait;
    public function list($per_page, $page, $q) {
        try {
            $data['q'] = $q;
            $query = Vendor::select('*');
            if ($q) {
                $query->where('business_name', 'LIKE', '%' . $q . '%');
            }
            $data['vendors'] = $query->orderBy('created_at', 'desc')->paginate($per_page);
            $data['vendors']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['vendors']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['vendors']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['vendors']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['vendors']->count();
            }
            return $data;
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function store($request)
    {
        $date = date_create();

        try {
            if ($request['id']) {
                $id = $request['id'];
                $vendor = Vendor::findOrFail($id);
                $message = "Data updated";
            } else {
                $id = 0;
                $vendor = new Vendor;
                $vendor->vendor_code = date_timestamp_get($date);
                $vendor->email = $request['email'];
                $vendor->password = Hash::make($request['password']);
                $message = "Data added";
            }
            $vendor->account_type =  $request['account_type'];
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

            if (preg_match('#^data:image.*?base64,#', $request['license_image'])) {
                $license_image = $this->StoreBase64Image($request['license_image'], '/vendor/');
            } else {
                $license_image = ($vendor) ? $vendor->license_image : '';
            }

            $vendor->image = $profile_image;
            $vendor->license_image = $license_image;
            $vendor->device_id = isset($request['device_id']) ? $request['device_id'] : null;
            $vendor->status = 0;
            $vendor->admin_approved = 0;
            $vendor->email_verified = 0;
            $vendor->is_deleted = 0;
            $vendor->save();

            //send verification email
            if($request['id'] == 0 ) {
                $token = encode_param($vendor->vendor_code);
                $emailData = [
                    'first_name' => $vendor->first_name,
                    'email' => $request['email'],
                    'password' => $request['password'],
                    'token' => $token
                ];
                Mail::send('email.vendor.verify_account', $emailData, function ($message) use ($request) {
                    $message->to($request['email']);
                    $message->subject('Qalaqs: Verify Your Account');
                });
            }

            //add bank details
            if($request['id'] == 0 ) {
                $bank = new Bank;
                $bank->vendor_id = $vendor->id;
                $bank->bank_name = $request['bank_name'] ? $request['bank_name'] : '';
                $bank->account_name = $request['account_name'] ? $request['account_name'] : '';
                $bank->account_no = $request['account_no'] ? $request['account_no'] : '';
                $bank->iban = $request['iban'] ? $request['iban'] : '';
                
                if($request['bank_image']) {
                    $bank_image = $this->StoreBase64Image($request['bank_image'], '/vendor/');
                }
                $bank->image = $bank_image;
                $bank->save();
            }
            
            $response['message'] = $message;
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function status($request)
    {
        try {
            Vendor::where('id', $request->id)
                ->update([
                    $request->field_name => $request->val,
                ]);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function delete($request)
    {
        try {
            $id = $request->id;
            Vendor::where('id', $id)->delete();
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function imageDelete($request) {
        try {
            $id = $request->id;
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
}
