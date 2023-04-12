<?php
namespace App\Services\Api\User;

use App\Models\User;
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
            $user->mobile = $request['mobile'];
            $user->device_id = isset($request['device_id']) ? $request['device_id']: null;
            $user->save();
            $response['data'] = $user;
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
        } catch (\Exception$e) {
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

}
