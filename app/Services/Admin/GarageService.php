<?php
namespace App\Services\Admin;

use App\Models\Garage;

class GarageService
{
    function list($per_page, $page, $q) {
        try {
            $data['q'] = $q;
            $query = Garage::select('*');
            if ($q) {
                $query->where('name', 'LIKE', '%' . $q . '%');
            }
            $data['garages'] = $query->orderBy('created_at', 'desc')->paginate($per_page);
            $data['garages']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['garages']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['garages']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['garages']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['garages']->count();
            }
            return $data;
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function status($request)
    {
        try {
            Garage::where('id', $request->id)
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
                $garage = Garage::findOrFail($id);
                $message = "Data updated";
            } else {
                $id = 0;
                $garage = new Garage;
                $message = "Data added";
            }
            $garage->name = $request['name'];
            $garage->address = $request['address'];
            $garage->phone = $request['phone'];
            $garage->logo = $request['logo'];
            $garage->image = $request['image'];
            $garage->map = $request['map'];
            $garage->description = $request['description'];
            $garage->status = isset($request['status']) ? 1 : 0;
            $garage->save();
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
            Garage::where('id', $id)->delete();
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}
