<?php
namespace App\Services\Api;

use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannerService
{
    public function list() {
        try {
            $banner_data = array();
            $banners = Banner::where('status', 1)->orderBy('order', 'asc')->get();
            if ($banners->count() > 0) {
                foreach ($banners as $banner) {
                    array_push($banner_data, array('id' => $banner->id, 'image' => Storage::disk('public')->url('banner/'.$banner->image)));
                }
            }
            $response['data'] = $banner_data;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    
}
