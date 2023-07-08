<?php
namespace App\Services\Admin;

use App\Models\Report;
use App\Models\Vendor;

class ReportService
{
    function make($per_page, $page, $q) {
        try {
            $data['q'] = $q;
            $query = Vendor::select('*')->with('makes');
            if ($q) {
                $query->where('name', 'LIKE', '%' . $q . '%');
            }
            $data['reports'] = $query->orderBy('business_name', 'asc')->paginate($per_page);
            $data['reports']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['reports']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['reports']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['reports']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['reports']->count();
            }
            return $data;
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}
