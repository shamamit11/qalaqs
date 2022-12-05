<?php
namespace App\Services\Admin;

use App\Models\ProductMake;
use App\Traits\StoreImageTrait;
use Illuminate\Support\Facades\Storage;

class MakeService
{
    use StoreImageTrait;
    public function list($per_page, $page, $q) {
        try {
            $data['q'] = $q;
            $query = ProductMake::select('*');
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
            return response()->json(['errors' => $e->getMessage()], 401);
        }
    }

    public function status($request)
    {
        try {
            ProductMake::where('id', $request->id)
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
                $make = ProductMake::findOrFail($id);
                $message = "Data updated";
            } else {
                $id = 0;
                $make = new ProductMake;
                $message = "Data added";
            }
            
            if (preg_match('#^data:image.*?base64,#', $request['image'])) {
                $image = $this->StoreBase64Image($request['image'], '/make/');
            } else {
                $image = ($make) ? $make->image : '';
            }
            $make->name = $request['name'];
            $make->status = isset($request['status']) ? 1 : 0;
            $make->image = $image;
            $make->save();
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
            $ras = ProductMake::findOrFail($id);
            Storage::disk('public')->delete('/make/' . $ras->image);
            ProductMake::where('id', $id)->delete();
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 401);
        }
    }

    public function imageDelete($request)
    {
        try {
            $id = $request->id;
            $field_name = $request->field_name;
            $ras = ProductMake::where('id', $id)->first();
            if ($ras) {
                Storage::disk('public')->delete('/make/' . $ras->$field_name);
                $ras->$field_name = '';
                $ras->save();
            }
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 401);
        }
    }
}
