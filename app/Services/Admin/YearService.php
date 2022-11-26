<?php
namespace App\Services\Admin;

use App\Models\ProductYear;

class YearService
{
    function list($per_page, $page, $q) {
        try {
            $data['q'] = $q;
            $query = ProductYear::select('*');
            if ($q) {
                $query->where('name', 'LIKE', '%' . $q . '%');
            }
            $data['years'] = $query->orderBy('name', 'asc')->paginate($per_page);
            $data['years']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['years']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['years']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['years']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['years']->count();
            }
            return $data;
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 401);
        }
    }

    public function status($request)
    {
        try {
            ProductYear::where('id', $request->id)
                ->update([
                    $request->field_name => $request->val,
                ]);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 401);
        }
    }

    public function store($request)
    {
        try {
            if ($request['id']) {
                $id = $request['id'];
                $year = ProductYear::findOrFail($id);
                $message = "Data updated";
            } else {
                $id = 0;
                $year = new ProductYear;
                $message = "Data added";
            }
            $year->name = $request['name'];
            $year->status = isset($request['status']) ? 1 : 0;
            $year->save();
            $response['message'] = $message;
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 401);
        }
    }

    public function delete($request)
    {
        try {
            $id = $request->id;
            ProductYear::where('id', $id)->delete();
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 401);
        }
    }
}
