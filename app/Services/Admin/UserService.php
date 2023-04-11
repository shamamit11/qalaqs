<?php
namespace App\Services\Admin;

use App\Models\User;

class UserService
{
    public function list($per_page, $page, $q) {
        try {
            $data['q'] = $q;
            $query = User::select('*');
            if ($q) {
                $query->where('business_name', 'LIKE', '%' . $q . '%');
            }
            $data['users'] = $query->orderBy('created_at', 'desc')->paginate($per_page);
            $data['users']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['users']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['users']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['users']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['users']->count();
            }
            return $data;
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function status($request)
    {
        try {
            User::where('id', $request->id)
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
            User::where('id', $id)->delete();
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}
