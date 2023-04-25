<?php
namespace App\Services\Admin;

use App\Models\Subcategory;
use App\Traits\StoreImageTrait;
use Illuminate\Support\Facades\Storage;

class SubcategoryService
{
    use StoreImageTrait;
    public function list($per_page, $page, $q) {
        try {
            $data['q'] = $q;
            $query = Subcategory::select('*')->with('category');
            if ($q) {
                $search_key = $q;
                $query->where(function ($qry) use ($search_key) {
                    $qry->where('name', 'LIKE', '%' . $search_key . '%');
                    $qry->orWhereHas('category', function ($qry1) use ($search_key) {
                        $qry1->where('name', 'LIKE', '%' . $search_key . '%');
                    });
                });
            }
            $data['subcategories'] = $query->orderBy('category_id', 'asc')->orderBy('order', 'asc')->paginate($per_page);
            $data['subcategories']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['subcategories']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['subcategories']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['subcategories']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['subcategories']->count();
            }
            return $data;
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function status($request)
    {
        try {
            Subcategory::where('id', $request->id)
                ->update([
                    $request->field_name => $request->val,
                ]);
                return 'success';
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function store($request)
    {
        try {
            if ($request['id']) {
                $id = $request['id'];
                $subcategory = Subcategory::findOrFail($id);
                $message = "Data updated";
            } else {
                $id = 0;
                $subcategory = new SubCategory;
                $message = "Data added";
            }
            $subcategory->category_id = $request['category_id'];
            $subcategory->name = $request['name'];
            $subcategory->order = $request['order'];
            $subcategory->icon = $request['icon'];
            $subcategory->status = isset($request['status']) ? 1 : 0;
            $subcategory->save();
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
            Subcategory::where('id', $id)->delete();
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}
