<?php
namespace App\Services\Api\User;

use App\Models\OrderItem;
use App\Models\OrderReturn;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\VendorReview;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VendorService
{ 
    public function vendorDetail($vendor_id) {
        try {
            $vendor_array = [];
            $vendor = Vendor::where('id', $vendor_id)->first();
            $vendor->image = env('APP_URL') . '/storage/vendor/' . $vendor->image;

            $product = Product::where('vendor_id', $vendor_id)->get();
            $vendor->total_products = count($product);

            $sales = OrderItem::where('vendor_id', $vendor_id)->get();
            $vendor->total_sales = count($sales);

            $returns = OrderReturn::where('vendor_id', $vendor_id)->get();
            $vendor->total_returns = count($returns);

            
            $rate = VendorReview::where('vendor_id', $vendor_id)->sum('rating');
            $rate_count = VendorReview::where('vendor_id', $vendor_id)->count();
            if($rate_count > 0) {
                $average_rating = floor($rate / $rate_count);
            } 
            else {
                $average_rating = 0;
            }
            $vendor->rating = getRatingStar($average_rating);

            $reviews = VendorReview::where('vendor_id', $vendor_id)->get()->makeHidden('user');
            foreach($reviews as $rev) {
                $rev->rating = getRatingStar($rev->rating);
                $rev->client = $rev->user->first_name . " " . $rev->user->last_name;
            }
            $vendor->reviews = $reviews;

            $vendor_array['detail'] = $vendor;

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

    public function addReview($request) {
        try {
            $user_id = Auth::guard('user-api')->id();

            $vendorReview = new VendorReview;
            $vendorReview->vendor_id = $request['vendor_id'];
            $vendorReview->user_id = $user_id;
            $vendorReview->rating = $request['rating'];
            $vendorReview->reviews = $request['reviews'];
            $vendorReview->save();

            $response['message'] = 'success';
            $response['errors'] = null;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        }
        catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}