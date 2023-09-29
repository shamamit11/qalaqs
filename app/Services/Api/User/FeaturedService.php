<?php
namespace App\Services\Api\User;

use App\Models\Garage;
use App\Models\Recovery;
use App\Models\AutoService;
use App\Models\Auction;

class FeaturedService
{

    public function garage()
    {
        try {
            $garages = Garage::where('status', 1)->orderBy('created_at', 'desc')->get();
            $response['data'] = $garages;
            $response['errors'] = false;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function recovery()
    {
        try {
            $recovery = Recovery::where('status', 1)->orderBy('created_at', 'desc')->get();
            $response['data'] = $recovery;
            $response['errors'] = false;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function autoservice()
    {
        try {
            $services = AutoService::where('status', 1)->orderBy('created_at', 'desc')->get();
            $response['data'] = $services;
            $response['errors'] = false;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function auction()
    {
        try {
            $auctions = Auction::where('status', 1)->orderBy('created_at', 'desc')->get();
            $response['data'] = $auctions;
            $response['errors'] = false;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

}