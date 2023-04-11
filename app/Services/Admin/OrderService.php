<?php
namespace App\Services\Admin;

use App\Models\Order;

class OrderService
{
    function list($per_page, $page, $q) {
        try {
            $data['q'] = $q;
            $query = Order::select('*')->with('user');
            if ($q) {
                $search_key = $q;
                $query->where(function ($qry) use ($search_key) {
                    $qry->where('order_id', 'LIKE', '%' . $search_key . '%');
                    $qry->orWhereHas('user', function ($qry1) use ($search_key) {
                        $qry1->where('first_name', 'LIKE', '%' . $search_key . '%');
                    });
                    $qry->orWhereHas('user', function ($qry2) use ($search_key) {
                        $qry2->where('last_name', 'LIKE', '%' . $search_key . '%');
                    });
                    $qry->orWhereHas('user', function ($qry3) use ($search_key) {
                        $qry3->where('business_name', 'LIKE', '%' . $search_key . '%');
                    });
                });
            }
            $data['orders'] = $query->orderBy('created_at', 'asc')->paginate($per_page);
            $data['orders']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['orders']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['orders']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['orders']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['orders']->count();
            }
            return $data;
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}
