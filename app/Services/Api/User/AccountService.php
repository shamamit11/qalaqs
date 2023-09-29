<?php
namespace App\Services\Api\User;

use App\Models\Notification;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Traits\StoreImageTrait;

class AccountService
{
    use StoreImageTrait;
    
    public function getProfile() {
        try {
            $id = Auth::guard('user-api')->id();
            $user = User::findOrFail($id);
            $userAddress = UserAddress::where('user_id', $id)->first();
            if($user->image) {
                $user->image = env('APP_URL').'/storage/user/'.$user->image;
                $user->address = $userAddress->address;
                $user->city = $userAddress->city;
                $user->country = $userAddress->country;
            }
            $response['data'] = $user;
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        } 
        catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
    public function updateProfile($request)
    {
        try {
            $id = Auth::guard('user-api')->id();
            $user = User::findOrFail($id);
            $user->first_name = $request['first_name'];
            $user->last_name = $request['last_name'];
            $user->business_name = isset($request['business_name']) ? $request['business_name']: null;
            $user->mobile = $request['mobile'];
            $user->device_id = isset($request['device_id']) ? $request['device_id']: null;
            $user->save();

            $addressExist = UserAddress::where('user_id', $id)->exists();
            if($addressExist) {
                $userAddress = UserAddress::where('user_id', $id)->first();
            } 
            else {
                $userAddress = new UserAddress();
                $user->user_id = $id;
            }
            $userAddress->address = $request['address'];
            $userAddress->city = $request['city'];
            $userAddress->country = $request['country'];
            $userAddress->save();

            $response['data'] = $user;
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        } 
        catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function updateProfileImage($request)
    {
        try {
            $id = Auth::guard('user-api')->user()->id;
            $user = User::where('id', $id)->first();

            $fileExists = Storage::disk('public')->exists('/user/' . $user->image);

            if($user->image && $fileExists) {
                Storage::disk('public')->delete('/user/' . $user->image);
            }
            
            $user->image = isset($request['image']) ? $this->StoreImage($request['image'], '/user/') : null;
            $user->save();

            $response['message'] = 'Success';
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        }
        catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        } 
    }

    public function updatePassword($request)
    {
        try {
            if (Hash::check($request['old_password'], Auth::guard('user-api')->user()->password)) {
                User::whereId(Auth::guard('user-api')->id())->update([
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
        } 
        catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function logout()
    {
        try {
            $tokens = Auth::guard('user-api')->user()->tokens;
            if ($tokens) {
                foreach ($tokens as $token) {
                    $token->revoke();
                }
            }
            Auth::guard('user-api')->logout(true);
            $response['message'] = __('logout');
            $response['errors'] = null;
            $response['status_code'] = 200;

            return response()->json($response, 200);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function updatePushToken($request)
    {
        $id = Auth::guard('user-api')->user()->id;
        $user = User::where('id', $id)->first();
        $user->device_id = $request['device_id'];
        $user->save();
        $response['message'] = 'Success';
        $response['errors'] = false;
        $response['status_code'] = 200;
        return response()->json($response, 200);
    }

    public function cancelAccount()
    {
        try {
            $id = Auth::guard('user-api')->user()->id;
            $user = User::findOrFail($id);
            if($user) {
                $user->is_deleted = 1;
                $user->status = 0;
                $user->save();
            }
            $response['message'] = 'Success';
            $response['errors'] = false;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }  
    }

    public function notification() {
        try {
            $user_id = Auth::guard('user-api')->user()->id;
            $notificationData = Notification::where([['receiver_id', $user_id], ['receiver_type', 'U'], ['status', 0]])->orderBy('created_at', 'desc')->get();

            $response['data'] = $notificationData;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        }
        catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function updateNotificationStatus($request) {
        try {
            $notification = Notification::where('id', $request['notification_id'])->first();
            $notification->status = 1;
            $notification->save();
            $response['message'] = 'Success';
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        }
        catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

}
