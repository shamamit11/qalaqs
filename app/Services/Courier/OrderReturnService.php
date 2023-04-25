<?php
namespace App\Services\Courier;

use App\Models\OrderReturn;

class OrderReturnService
{
    function list($per_page, $page, $q) {
        try {
            $data['q'] = $q;
            $query = OrderReturn::select('*')->with('user')->with('order');
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
                    $qry->orWhereHas('order', function ($qry3) use ($search_key) {
                        $qry3->where('order_id', 'LIKE', '%' . $search_key . '%');
                    });
                });
            }
            $data['returns'] = $query->orderBy('created_at', 'asc')->paginate($per_page);
            $data['returns']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['returns']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['returns']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['returns']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['returns']->count();
            }
            return $data;
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function status($request)
    {
        try {
            OrderReturn::where('id', $request->id)
                ->update([
                    $request->field_name => $request->val,
                ]);
            return 'success';
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}
