<?php
namespace App\Services\Admin;

use App\Models\ProductEngine;
use App\Models\ProductMake;
use App\Models\ProductModel;
use App\Models\ProductYear;

class EngineService
{
    public function list($per_page, $page, $q) {
        try {
            $data['q'] = $q;
            $query = ProductEngine::select('*')->with('make')->with('model')->with('year');
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
            $data['engines'] = $query->orderBy('product_make_id', 'asc')->orderBy('product_model_id', 'asc')->orderBy('product_year_id', 'asc')->orderBy('id', 'desc')->paginate($per_page);
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
            ProductEngine::where('id', $request->id)
                ->update([
                    $request->field_name => $request->val,
                ]);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function store($request)
    {
        try {
            if ($request['id']) {
                $id = $request['id'];
                $engine = ProductEngine::findOrFail($id);
                $message = "Data updated";
            } else {
                $id = 0;
                $engine = new ProductEngine;
                $message = "Data added";
            }
            $engine->product_make_id = $request['make_id'];
            $engine->product_model_id = $request['model_id'];
            $engine->product_make_id = $request['make_id'];
            $engine->product_year_id = $request['year_id'];
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
            ProductEngine::where('id', $id)->delete();
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}
