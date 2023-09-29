<?php
namespace App\Services\Api\User;

use App\Models\TempQuoteItem;
use App\Models\User;
use App\Traits\StoreImageTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TempQuoteItemService
{
    use StoreImageTrait;

    public function list($quote_session_id)
    {
        try {
            $user_id = Auth::guard('user-api')->id();
            $quote_items = TempQuoteItem::where([['user_id', $user_id], ['quote_session_id', $quote_session_id]])->get();

            if (count($quote_items) > 0) {
                foreach ($quote_items as $item) {
                    if ($item->part_image) {
                        $item->part_image = env('APP_URL') . '/storage/quotes/' . $item->part_image;
                    }
                }
                $response['data'] = $quote_items;
                $response['message'] = null;
                $response['errors'] = null;
                $response['status_code'] = 200;
                return response()->json($response, 200);
            } else {
                $response['data'] = [];
                $response['errors'] = null;
                $response['status_code'] = 200;
                return response()->json($response, 200);
            }
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
    public function addItem($request)
    {
        try {
            $user_id = Auth::guard('user-api')->id();
            $temp_quote = new TempQuoteItem();
            $temp_quote->quote_session_id = $request['quote_session_id'];
            $temp_quote->user_id = $user_id;
            $temp_quote->part_image = isset($request['part_image']) ? $this->StoreImage($request['part_image'], '/quotes/') : null;
            $temp_quote->part_name = $request['part_name'];
            $temp_quote->part_number = $request['part_number'];
            $temp_quote->qty = $request['qty'];
            $temp_quote->save();

            $response['message'] = 'success';
            $response['errors'] = null;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function deleteItem($request)
    {
        try {
            $quote_session_id = $request['quote_session_id'];
            $user_id = Auth::guard('user-api')->id();
            $quote_item_id = $request['item_id'];

            $item = TempQuoteItem::where([['id', $quote_item_id], ['quote_session_id', $quote_session_id], ['user_id', $user_id]])->first();
            Storage::disk('public')->delete('/quotes/' . $item->part_image);
            $item->delete();

            $response['message'] = "success";
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);

        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}