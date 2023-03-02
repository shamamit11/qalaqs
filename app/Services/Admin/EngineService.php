<?php
namespace App\Services\Admin;

use App\Models\Engine;

class EngineService
{
    function list($per_page, $page, $q) {
        try {
            $data['q'] = $q;
            $query = Engine::select('*')->with('make')->with('model')->with('year');
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
                    $qry->orWhereHas('year', function ($qry3) use ($search_key) {
                        $qry3->where('name', 'LIKE', '%' . $search_key . '%');
                    });
                });
            }
            $data['engines'] = $query->orderBy('make_id', 'asc')->orderBy('model_id', 'asc')->orderBy('year_id', 'asc')->orderBy('id', 'desc')->paginate($per_page);
            $data['engines']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['engines']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['engines']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['engines']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['engines']->count();
            }
            return $data;
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function status($request)
    {
        try {
            Engine::where('id', $request->id)
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
                $engine = Engine::findOrFail($id);
                $message = "Data updated";
            } else {
                $id = 0;
                $engine = new Engine;
                $message = "Data added";
            }
            $engine->make_id = $request['make_id'];
            $engine->model_id = $request['model_id'];
            $engine->make_id = $request['make_id'];
            $engine->year_id = $request['year_id'];
            $engine->name = $request['name'];
            $engine->status = isset($request['status']) ? 1 : 0;
            $engine->save();
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
            Engine::where('id', $id)->delete();
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}
