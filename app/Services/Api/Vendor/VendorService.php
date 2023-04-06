<?php
namespace App\Services\Api\Vendor;

use App\Models\OrderItem;
use App\Models\OrderReturn;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\VendorReview;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VendorService
{ 
    public function vendorDetail() {
        try {
            $vendor_id = Auth::guard('vendor-api')->user()->id;
            
            $vendor_array = [];
            $vendor = Vendor::where('id', $vendor_id)->first();

            $product = Product::where('vendor_id', $vendor_id)->get();
            $vendor->total_products = count($product);

            $sales = OrderItem::where('vendor_id', $vendor_id)->get();
            $vendor->total_sales = count($sales);

            $returns = OrderReturn::where('vendor_id', $vendor_id)->get();
            $vendor->total_returns = count($returns);

            
            $rate = VendorReview::where('vendor_id', $vendor_id)->sum('rating');
            $rate_count = VendorReview::where('vendor_id', $vendor_id)->count();
            if($rate_count > 0) {
                $vendor->average_rating = floor($rate / $rate_count);
            }

            $reviews = VendorReview::where('vendor_id', $vendor_id)->get();
            $vendor->reviews = $reviews;

            if($vendor->image) {
                $vendor->image = env('APP_URL').'/storage/vendor/'.$vendor->image;
            }

            if($vendor->license_image) {
                $vendor->license_image = env('APP_URL').'/storage/vendor/'.$vendor->license_image;
            }
        
            $vendor_array['detail'] = $vendor;

            $response['data'] = $vendor_array;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } 
        catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function vendorStats() {
        try {
            $vendor_id = Auth::guard('vendor-api')->user()->id;

            $vendor = [];

            $total_sales = OrderItem::where('vendor_id', $vendor_id)->sum('sub_total');
            $vendor['total_sales'] = $total_sales;

            $product = Product::where('vendor_id', $vendor_id)->get();
            $vendor['total_products'] = count($product);

            $new_sales = OrderItem::where([['vendor_id', $vendor_id], ['created_at', '>=', Carbon::now()->subDays(1)]])->get();
            $vendor['new_orders'] = count($new_sales);

            $returns = OrderReturn::where('vendor_id', $vendor_id)->get();
            $vendor['order_returns'] = count($returns);

            $vendor['date'] = Carbon::tomorrow();

            $response['data'] = $vendor;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        }
        catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}