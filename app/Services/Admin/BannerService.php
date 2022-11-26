<?php
namespace App\Services\Admin;

use App\Models\Banner;
use App\Traits\StoreImageTrait;
use Illuminate\Support\Facades\Storage;

class BannerService
{
    use StoreImageTrait;
    function list($per_page, $page, $q) {
        try {
            $data['q'] = $q;
            $query = Banner::select('*');
            if ($q) {
                $query->where('name', 'LIKE', '%' . $q . '%');
            }
            $data['banners'] = $query->orderBy('order', 'asc')->paginate($per_page);
            $data['banners']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['banners']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['banners']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['banners']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['banners']->count();
            }
            return $data;
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 401);
        }
    }

    public function status($request)
    {
        try {
            Banner::where('id', $request->id)
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
                $banner = Banner::findOrFail($id);
                $message = "Data updated";
            } else {
                $id = 0;
                $banner = new Banner;
                $message = "Data added";
            }
            
            if (preg_match('#^data:image.*?base64,#', $request['image'])) {
                $image = $this->StoreBase64Image($request['image'], '/banner/');
            } else {
                $image = ($banner) ? $banner->image : '';
            }
            $banner->name = $request['name'];
            $banner->order = $request['order'];
            $banner->status = isset($request['status']) ? 1 : 0;
            $banner->image = $image;
            $banner->save();
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
            $ras = Banner::findOrFail($id);
            Storage::disk('public')->delete('/banner/' . $ras->image);
            Banner::where('id', $id)->delete();
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
            $ras = Banner::where('id', $id)->first();
            if ($ras) {
                Storage::disk('public')->delete('/banner/' . $ras->$field_name);
                $ras->$field_name = '';
                $ras->save();
            }
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 401);
        }
    }
}
