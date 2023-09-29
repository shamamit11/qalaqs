<?php
namespace App\Services\Admin;

use App\Models\Auction;

class AuctionService
{
    function list($per_page, $page, $q) {
        try {
            $data['q'] = $q;
            $query = Auction::select('*');
            if ($q) {
                $query->where('name', 'LIKE', '%' . $q . '%');
            }
            $data['auctions'] = $query->orderBy('created_at', 'desc')->paginate($per_page);
            $data['auctions']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['auctions']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['auctions']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['auctions']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['auctions']->count();
            }
            return $data;
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function status($request)
    {
        try {
            Auction::where('id', $request->id)
                ->update([
                    $request->field_name => $request->val,
                ]);
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function store($request)
    {
        try {
            if ($request['id']) {
                $id = $request['id'];
                $auction = Auction::findOrFail($id);
                $message = "Data updated";
            } else {
                $id = 0;
                $auction = new Auction;
                $message = "Data added";
            }
            $auction->name = $request['name'];
            $auction->description = $request['description'];
            $auction->date = $request['date'];
            $auction->time = $request['time'];
            $auction->location = $request['location'];
            $auction->phone = $request['phone'];
            $auction->logo = $request['logo'];
            $auction->image = $request['image'];
            $auction->map = $request['map'];
            $auction->status = isset($request['status']) ? 1 : 0;
            $auction->save();
            
            $response['message'] = $message;
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function delete($request)
    {
        try {
            $id = $request->id;
            Auction::where('id', $id)->delete();
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}
