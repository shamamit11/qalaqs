<?php
namespace App\Services\Api\User;

use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannerService
{
    public function list() {
        try {
            $banners = Banner::where('status', 1)->orderBy('order', 'asc')->get()->makeHidden(['id', 'name', 'image', 'order', 'status', 'created_at', 'updated_at']);
            foreach($banners as $item) {
                $item->img = $item->image;
            }
            $response['data'] = $banners;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    
}
