<?php
namespace App\Services\Api\User;

use App\Models\ProductInquiry;
use Illuminate\Support\Facades\Auth;

class ProductInquiryService
{

    public function create($request)
    {
        try {
            $user_id = Auth::guard('user-api')->id();
            
            $quote = new ProductInquiry();
            $quote->user_id = $user_id;
            $quote->product_id = $request['product_id'];
            $quote->save();

            $response['message'] = 'success';
            $response['errors'] = null;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        } 
        catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}