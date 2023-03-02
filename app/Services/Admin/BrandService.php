<?php
namespace App\Services\Admin;

use App\Models\Brand;
use App\Traits\StoreImageTrait;
use Illuminate\Support\Facades\Storage;

class BrandService
{
    use StoreImageTrait;
    function list($per_page, $page, $q) {
        try {
            $data['q'] = $q;
            $query = Brand::select('*');
            if ($q) {
                $query->where('name', 'LIKE', '%' . $q . '%');
            }
            $data['brands'] = $query->orderBy('order', 'asc')->paginate($per_page);
            $data['brands']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['brands']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['brands']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['brands']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['brands']->count();
            }
            return $data;
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function status($request)
    {
        try {
            Brand::where('id', $request->id)
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
                $brand = Brand::findOrFail($id);
                $message = "Data updated";
            } else {
                $id = 0;
                $brand = new Brand;
                $message = "Data added";
            }

            if (preg_match('#^data:image.*?base64,#', $request['image'])) {
                $image = $this->StoreBase64Image($request['image'], '/brand/');
            } else {
                $image = ($brand) ? $brand->image : '';
            }
            $brand->name = $request['name'];
            $brand->order = $request['order'];
            $brand->status = isset($request['status']) ? 1 : 0;
            $brand->image = $image;
            $brand->save();
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
            $ras = Brand::findOrFail($id);
            Storage::disk('public')->delete('/brand/' . $ras->image);
            Brand::where('id', $id)->delete();
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function imageDelete($request)
    {
        try {
            $id = $request->id;
            $field_name = $request->field_name;
            $ras = Brand::where('id', $id)->first();
            if ($ras) {
                Storage::disk('public')->delete('/brand/' . $ras->$field_name);
                $ras->$field_name = '';
                $ras->save();
            }
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}
