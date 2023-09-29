<?php
namespace App\Services\Admin;

use App\Models\Recovery;

class RecoveryService
{
    function list($per_page, $page, $q) {
        try {
            $data['q'] = $q;
            $query = Recovery::select('*');
            if ($q) {
                $query->where('name', 'LIKE', '%' . $q . '%');
            }
            $data['recoveries'] = $query->orderBy('created_at', 'desc')->paginate($per_page);
            $data['recoveries']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['recoveries']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['recoveries']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['recoveries']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['recoveries']->count();
            }
            return $data;
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function status($request)
    {
        try {
            Recovery::where('id', $request->id)
                ->update([
                    $request->field_name => $request->val,
                ]);
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function store($request)
    {
        try {
            if ($request['id']) {
                $id = $request['id'];
                $recovery = Recovery::findOrFail($id);
                $message = "Data updated";
            } else {
                $id = 0;
                $recovery = new Recovery;
                $message = "Data added";
            }
            $recovery->name = $request['name'];
            $recovery->address = $request['address'];
            $recovery->phone = $request['phone'];
            $recovery->logo = $request['logo'];
            $recovery->image = $request['image'];
            $recovery->map = $request['map'];
            $recovery->description = $request['description'];
            $recovery->status = isset($request['status']) ? 1 : 0;
            $recovery->save();
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
            $id = $request->id;
            Recovery::where('id', $id)->delete();
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}
