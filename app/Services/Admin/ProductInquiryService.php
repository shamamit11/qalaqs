<?php
namespace App\Services\Admin;

use App\Models\ProductInquiry;

class ProductInquiryService
{
    function list($per_page, $page, $q) {
        try {
            $data['q'] = $q;
            $query = ProductInquiry::select('*');
            if ($q) {
                $search_key = $q;
                $query->where(function ($qry) use ($search_key) {
                    $qry->where('quote_id', 'LIKE', '%' . $search_key . '%');
                });
            }
            $data['inquiries'] = $query->orderBy('created_at', 'desc')->paginate($per_page);
            $data['inquiries']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['inquiries']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['inquiries']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['inquiries']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['inquiries']->count();
            }
            return $data;
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}
