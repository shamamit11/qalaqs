<?php
namespace App\Services\Admin;

use App\Models\Vendor;

class VendorService
{
    public function list($per_page, $page, $q) {
        try {
            $data['q'] = $q;
            $query = Vendor::select('*');
            if ($q) {
                $query->where('name', 'LIKE', '%' . $q . '%');
            }
            $data['vendors'] = $query->orderBy('name', 'asc')->paginate($per_page);
            $data['vendors']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['vendors']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['vendors']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['vendors']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['vendors']->count();
            }
            return $data;
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function status($request)
    {
        try {
            Vendor::where('id', $request->id)
                ->update([
                    $request->field_name => $request->val,
                ]);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function delete($request)
    {
        try {
            $id = $request->id;
            Vendor::where('id', $id)->delete();
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}
