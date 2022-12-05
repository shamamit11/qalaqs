<?php
namespace App\Services\Admin;

use App\Models\ProductMake;
use App\Models\ProductModel;
use App\Traits\StoreImageTrait;
use Illuminate\Support\Facades\Storage;

class ModelService
{
    use StoreImageTrait;
    public function list($per_page, $page, $q) {
        try {
            $data['q'] = $q;
            $query = ProductModel::select('*')->with('make');
            if ($q) {
                $search_key = $q;
                $query->where(function ($qry) use ($search_key) {
                    $qry->where('name', 'LIKE', '%' . $search_key . '%');
                    $qry->orWhereHas('make', function ($qry1) use ($search_key) {
                        $qry1->where('name', 'LIKE', '%' . $search_key . '%');
                    });
                });
            }
            $data['models'] = $query->orderBy('product_make_id', 'asc')->orderBy('id', 'desc')->paginate($per_page);
            $data['models']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['models']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['models']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['models']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['models']->count();
            }
            return $data;
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 401);
        }
    }

    public function status($request)
    {
        try {
            ProductModel::where('id', $request->id)
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
                $model = ProductModel::findOrFail($id);
                $message = "Data updated";
            } else {
                $id = 0;
                $model = new ProductModel;
                $message = "Data added";
            }
            $model->product_make_id = $request['make_id'];
            $model->name = $request['name'];
            $model->status = isset($request['status']) ? 1 : 0;
            $model->save();
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
            ProductModel::where('id', $id)->delete();
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 401);
        }
    }
}
