<?php
namespace App\Services\Admin;

use App\Models\ProductImage;

class ProductImageService
{
    function list($per_page, $page, $q) {
        try {
            $data['q'] = $q;
            $query = ProductImage::select('*')->with('subcategory');
            if ($q) {
                $search_key = $q;
                $query->where(function ($qry) use ($search_key) {
                    $qry->where('make', function ($qry1) use ($search_key) {
                        $qry1->where('name', 'LIKE', '%' . $search_key . '%');
                    });
                });
            }
            $data['product_images'] = $query->paginate($per_page);
            $data['product_images']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['product_images']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['product_images']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['product_images']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['product_images']->count();
            }
            return $data;
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function status($request)
    {
        try {
            ProductImage::where('id', $request->id)
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
                $product_image = ProductImage::findOrFail($id);
                $message = "Data updated";
            } else {
                $id = 0;
                $product_image = new ProductImage;
                $message = "Data added";
            }
            $product_image->category_id = $request['category_id'];
            $product_image->subcategory_id = $request['subcategory_id'];
            $product_image->make_id = $request['make_id'];
            $product_image->model_id = $request['model_id'];
            $product_image->year_id = $request['year_id'];
            $product_image->image = $request['image'];
            $product_image->status = isset($request['status']) ? 1 : 0;
            $product_image->save();
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
            ProductImage::where('id', $id)->delete();
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}
