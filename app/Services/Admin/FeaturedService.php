<?php
namespace App\Services\Admin;

use App\Models\AutoService;

class FeaturedService
{
    function list($per_page, $page, $q) {
        try {
            $data['q'] = $q;
            $query = AutoService::select('*');
            if ($q) {
                $query->where('title', 'LIKE', '%' . $q . '%');
            }
            $data['services'] = $query->orderBy('created_at', 'desc')->paginate($per_page);
            $data['services']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['services']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['services']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['services']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['services']->count();
            }
            return $data;
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function status($request)
    {
        try {
            AutoService::where('id', $request->id)
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
                $service = AutoService::findOrFail($id);
                $message = "Data updated";
            } else {
                $id = 0;
                $service = new AutoService;
                $message = "Data added";
            }
            $service->title = $request['title'];
            $service->description = $request['description'];
            $service->phone = $request['phone'];
            $service->logo = $request['logo'];
            $service->image = $request['image'];
            $service->status = isset($request['status']) ? 1 : 0;
            $service->save();
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
            AutoService::where('id', $id)->delete();
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}
