<?php
namespace App\Services\Admin;

use App\Models\Year;

class YearService
{
    function list($per_page, $page, $q) {
        try {
            $data['q'] = $q;
            $query = Year::select('*')->with('make')->with('model');
            if ($q) {
                $search_key = $q;
                $query->where(function ($qry) use ($search_key) {
                    $qry->where('name', 'LIKE', '%' . $search_key . '%');
                    $qry->orWhereHas('make', function ($qry1) use ($search_key) {
                        $qry1->where('name', 'LIKE', '%' . $search_key . '%');
                    });
                    $qry->orWhereHas('model', function ($qry2) use ($search_key) {
                        $qry2->where('name', 'LIKE', '%' . $search_key . '%');
                    });
                });
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
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function status($request)
    {
        try {
            Year::where('id', $request->id)
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
                $year = Year::findOrFail($id);
                $message = "Data updated";
            } else {
                $id = 0;
                $year = new Year;
                $message = "Data added";
            }
            $year->name = $request['name'];
            $year->make_id = 2;
            $year->model_id = 2;
            $year->status = isset($request['status']) ? 1 : 0;
            $year->save();
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
            ProductYear::where('id', $id)->delete();
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}
