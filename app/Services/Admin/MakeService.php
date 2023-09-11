<?php
namespace App\Services\Admin;

use App\Models\Make;
use App\Models\VendorMake;
use App\Traits\StoreImageTrait;
use Illuminate\Support\Facades\Storage;

class MakeService
{
    use StoreImageTrait;
    function list($per_page, $page, $q) {
        try {
            $data['q'] = $q;
            $query = Make::select('*');
            if ($q) {
                $query->where('name', 'LIKE', '%' . $q . '%');
            }
            $data['makes'] = $query->orderBy('id', 'desc')->paginate($per_page);
            $data['makes']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['makes']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['makes']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['makes']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['makes']->count();
            }
            return $data;
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function status($request)
    {
        try {
            Make::where('id', $request->id)
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
                $make = Make::findOrFail($id);
                $message = "Data updated";
            } else {
                $id = 0;
                $make = new Make;
                $message = "Data added";
            }
            $make->name = $request['name'];
            $make->icon = $request['icon'];
            $make->status = isset($request['status']) ? 1 : 0;
            $make->save();
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
            Make::where('id', $id)->delete();
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    function vendors($per_page, $page, $make_id) {
        try {
            $query = VendorMake::select('*')->where('make_id', $make_id);
            $data['vendors'] = $query->orderBy('id', 'desc')->paginate($per_page);
            if ($page != 1) {
                $data['total_data'] = $data['vendors']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['vendors']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['vendors']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['vendors']->count();
            }
            return $data;
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}
