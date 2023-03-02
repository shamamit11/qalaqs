<?php
namespace App\Services\Admin;

use App\Models\Category;
use App\Traits\StoreImageTrait;
use Illuminate\Support\Facades\Storage;

class CategoryService
{
    use StoreImageTrait;
    function list($per_page, $page, $q) {
        try {
            $data['q'] = $q;
            $query = Category::select('*');
            if ($q) {
                $query->where('name', 'LIKE', '%' . $q . '%');
            }
            $data['categories'] = $query->orderBy('order', 'asc')->paginate($per_page);
            $data['categories']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['categories']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['categories']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['categories']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['categories']->count();
            }
            return $data;
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function status($request)
    {
        try {
            Category::where('id', $request->id)
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
                $category = Category::findOrFail($id);
                $message = "Data updated";
            } else {
                $id = 0;
                $category = new Category;
                $message = "Data added";
            }
            $category->name = $request['name'];
            $category->order = $request['order'];
            $category->status = isset($request['status']) ? 1 : 0;
            $category->save();
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
            Category::where('id', $id)->delete();
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}
