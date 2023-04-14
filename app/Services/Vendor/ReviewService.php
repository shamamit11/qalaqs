<?php
namespace App\Services\Vendor;

use App\Models\VendorReview;
use Illuminate\Support\Facades\Auth;

class ReviewService
{ 

    function list($per_page, $page, $q) {
        try {
            $vendor_id = Auth::guard('vendor')->id();
            $data['q'] = $q;
            $query = VendorReview::select('*')->with('user');
            if ($q) {
                $search_key = $q;
                $query->where(function ($qry) use ($search_key) {
                    $qry->where('id', 'LIKE', '%' . $search_key . '%');
                    $qry->orWhereHas('user', function ($qry1) use ($search_key) {
                        $qry1->where('first_name', 'LIKE', '%' . $search_key . '%');
                    });
                    $qry->orWhereHas('user', function ($qry2) use ($search_key) {
                        $qry2->where('last_name', 'LIKE', '%' . $search_key . '%');
                    });
                });
            }
            $data['reviews'] = $query->where('vendor_id', $vendor_id)->orderBy('created_at', 'desc')->paginate($per_page);
            $data['reviews']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['reviews']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['reviews']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['reviews']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['reviews']->count();
            }
            return $data;
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}