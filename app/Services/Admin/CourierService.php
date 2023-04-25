<?php
namespace App\Services\Admin;

use App\Models\Courier;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Traits\StoreImageTrait;
use Illuminate\Support\Facades\Mail;

class CourierService
{
    use StoreImageTrait;
    public function list($per_page, $page, $q) {
        try {
            $data['q'] = $q;
            $query = Courier::select('*');
            if ($q) {
                $query->where('business_name', 'LIKE', '%' . $q . '%');
            }
            $data['couriers'] = $query->orderBy('created_at', 'desc')->paginate($per_page);
            $data['couriers']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['couriers']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['couriers']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['couriers']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['couriers']->count();
            }
            return $data;
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function status($request)
    {
        try {
            Courier::where('id', $request->id)
                ->update([
                    $request->field_name => $request->val,
                ]);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function store($request) {
        try {
            if ($request['id']) {
                $id = $request['id'];
                $courier = Courier::findOrFail($id);
                $message = "Data updated";
            } 
            else {
                $id = 0;
                $courier = new Courier;
                $message = "Data added";
                $date = date_create();
                $courier->courier_code = date_timestamp_get($date);
                $courier->verification_code = rand(1000, 9999);
                $courier->email_verified = 0;
                $courier->status = 0;
                $courier->is_deleted = 0;
            }

            if (preg_match('#^data:image.*?base64,#', $request['image'])) {
                $image = $this->StoreBase64Image($request['image'], '/courier/');
            } else {
                $image = $courier ? $courier->image : '';
            }

            if (preg_match('#^data:image.*?base64,#', $request['license_image'])) {
                $license_image = $this->StoreBase64Image($request['license_image'], '/courier/');
            } else {
                $license_image = $courier ? $courier->license_image : '';
            }

            $courier->account_type = $request['account_type'];
            $courier->business_name = $request['business_name'];
            $courier->first_name = $request['first_name'];
            $courier->last_name = $request['last_name'];
            $courier->designation = $request['designation'];
            $courier->mobile = $request['mobile'];
            $courier->phone = $request['phone'];
            $courier->address = $request['address'];
            $courier->city = $request['city'];
            $courier->email = $request['email'];
            $courier->password = isset($request['password']) ? Hash::make($request['password']) : $courier->password;
            $courier->image = $image;
            $courier->license_image = $license_image;
            $courier->save();

            if($request['id'] == 0) {
                $courier_code = encode_param($courier->courier_code);
                $token = encode_param($courier->verification_code);
                $emailData = [
                    'name' => $courier->first_name,
                    'token' => $token,
                    'code' => $courier_code
                ];
                Mail::send('email.courier.verify_account', $emailData, function ($message) use ($request) {
                    $message->to($request['email']);
                    $message->subject('Qalaqs: Verify Your Account');
                });
            }

            $response['message'] = $message;
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function delete($request)
    {
        try {
            Courier::where('id', $request->id)
                ->update([
                    'is_deleted' => 1,
                ]);
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function imageDelete($request) {
        try {
            $id = $request['id'];
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
}
