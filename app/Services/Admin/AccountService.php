<?php
namespace App\Services\Admin;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountService
{
    public function addAction($request)
    {
        try {
            $id = Auth::guard('admin')->id();
            $admin = Admin::findOrFail($id);
            $admin->name = $request['name'];
            $admin->save();
            $response['data'] = $admin;
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
            if (Hash::check($request['old_password'], Auth::guard('admin')->user()->password)) {
                Admin::whereId(Auth::guard('admin')->id())->update([
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

    function listUsers($per_page, $page, $q) {
        try {
            $data['q'] = $q;
            $query = Admin::select('*');
            if ($q) {
                $query->where('name', 'LIKE', '%' . $q . '%');
            }
            $data['system_users'] = $query->where('user_type', 'A');
            $data['system_users'] = $query->orderBy('id', 'asc')->paginate($per_page);
            $data['system_users']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['system_users']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['system_users']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['system_users']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['system_users']->count();
            }
            return $data;
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function systemUserAdd($request)
    {
        try {
            if ($request['id']) {
                $id = $request['id'];
                $admin = Admin::findOrFail($id);
                $message = "Data updated";
            } else {
                $id = 0;
                $admin = new Admin;
                $admin->username = $request['username'];
                $admin->password = Hash::make($request['password']);
                $message = "Data added";
            }
            $admin->name = $request['name'];
            $admin->email = $request['email'];
            $admin->image = '';
            $admin->user_type = 'A';
            $admin->status = isset($request['status']) ? 1 : 0;
            $admin->save();
            $response['message'] = $message;
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function updateUserStatus($request)
    {
        try {
            Admin::where('id', $request->id)
                ->update([
                    $request->field_name => $request->val,
                ]);
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function deleteUser($request)
    {
        try {
            $id = $request->id;
            Admin::where('id', $id)->delete();
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

}
