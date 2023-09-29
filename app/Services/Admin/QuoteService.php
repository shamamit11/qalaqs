<?php
namespace App\Services\Admin;

use App\Models\Quote;

class QuoteService
{
    function list($per_page, $page, $q) {
        try {
            $data['q'] = $q;
            $query = Quote::select('*');
            if ($q) {
                $search_key = $q;
                $query->where(function ($qry) use ($search_key) {
                    $qry->where('quote_id', 'LIKE', '%' . $search_key . '%');
                });
            }
            $data['quotes'] = $query->orderBy('created_at', 'desc')->paginate($per_page);
            $data['quotes']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['quotes']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['quotes']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['quotes']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['quotes']->count();
            }
            return $data;
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    function update($request) {
        try {
            $id = $request['id'];
            $quote = Quote::findOrFail($id);
            $quote->status = $request['status'];
            $quote->save();
            $message = "Data updated";
    
            $response['message'] = $message;
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        }
        catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}
