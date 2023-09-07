<?php
namespace App\Services\Admin;

use App\Models\SpecialOrder;

class SpecialRequestService
{
    function list($per_page, $page, $q) {
        try {
            $data['q'] = $q;
            $query = SpecialOrder::select('*');
            if ($q) {
                $search_key = $q;
                $query->where(function ($qry) use ($search_key) {
                    $qry->where('order_id', 'LIKE', '%' . $search_key . '%');
                    $qry->orWhere('part_number', 'LIKE', '%' . $search_key . '%');
                    $qry->orWhere('chasis_number', 'LIKE', '%' . $search_key . '%');
                    $qry->orWhere('name', 'LIKE', '%' . $search_key . '%');
                    $qry->orWhere('email', 'LIKE', '%' . $search_key . '%');
                    $qry->orWhere('mobile', 'LIKE', '%' . $search_key . '%');
                    $qry->orWhere('country', 'LIKE', '%' . $search_key . '%');
                    $qry->orWhere('city', 'LIKE', '%' . $search_key . '%');
                });
            }
            $data['specialrequests'] = $query->orderBy('created_at', 'asc')->paginate($per_page);
            $data['specialrequests']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['specialrequests']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['specialrequests']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['specialrequests']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['specialrequests']->count();
            }
            return $data;
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}
