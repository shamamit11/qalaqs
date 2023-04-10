<?php
namespace App\Services\Admin;

use App\Models\Product;
use App\Traits\StoreImageTrait;

class ProductService
{
    use StoreImageTrait;

    function list($per_page, $page, $q) {
        try {
            $data['q'] = $q;
            $query = Product::select('*')->with('specifications')->with('images')->with('make')->with('model')->with('year');
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
            $data['products'] = $query->orderBy('make_id', 'asc')->orderBy('model_id', 'asc')->orderBy('year_id', 'asc')->orderBy('id', 'desc')->paginate($per_page);
            $data['products']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['products']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['products']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['products']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['products']->count();
            }
            return $data;
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function status($request)
    {
        try {
            Product::where('id', $request->id)
                ->update([
                    $request->field_name => $request->val,
                ]);
            return 'success';
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function delete($request)
    {
        try {
            $id = $request->id;
            Product::where('id', $id)->delete();
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}
