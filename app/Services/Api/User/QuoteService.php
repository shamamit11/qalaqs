<?php
namespace App\Services\Api\User;

use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\TempQuoteItem;
use App\Models\User;
use App\Traits\StoreImageTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class QuoteService
{
    use StoreImageTrait;

    public function create($request)
    {
        try {
            $user_id = Auth::guard('user-api')->id();
            
            $quote = new Quote();
            $quote->quote_id = $request['quote_id'];
            $quote->user_id = $user_id;
            $quote->part_type = $request['part_type'];
            $quote->make_id = $request['make_id'];
            $quote->model_id = $request['model_id'];
            $quote->year_id = $request['year_id'];
            $quote->engine = $request['engine'];
            $quote->vin = isset($request['vin']) ? $this->StoreImage($request['vin'], '/quotes/') : null;
            $quote->status = "On Process";
            $quote->save();

            $tempQuoteItems = TempQuoteItem::where([['quote_session_id', $request['quote_id']], ['user_id', $user_id]])->get();
            foreach ($tempQuoteItems as $item) {
                $quoteItem = new QuoteItem;
                $quoteItem->quote_session_id = $item->quote_session_id;
                $quoteItem->user_id = $user_id;
                $quoteItem->part_image = $item->part_image;
                $quoteItem->part_name = $item->part_name;
                $quoteItem->part_number = $item->part_number;
                $quoteItem->qty = $item->qty;
                $quoteItem->save();
            }

            TempQuoteItem::where([['quote_session_id', $request['quote_id']], ['user_id', $user_id]])->delete();

            $emailData = [
                'user' => User::where('id', $user_id)->first(),
                'quote_id' => $request['quote_id']
            ];

            Mail::send('email.admin.quoterequest', $emailData, function ($message) use ($request) {
                $message->to('info@qalaqs.com');
                $message->subject('Qalaqs: New Quote Request');
            });
            
            $response['message'] = 'success';
            $response['errors'] = null;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        } 
        catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function list()
    {
        try {
            $user_id = Auth::guard('user-api')->id();
            $quotes = Quote::where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
            foreach ($quotes as $quote) {
                $quote->quote_date = date("d M Y", strtotime($quote->created_at));
            }
            $response['data'] = $quotes;
            $response['errors'] = false;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function getQuoteDetails($quote_id) {
        try {
            $user_id = Auth::guard('user-api')->id();
            $quote = Quote::where([['user_id', $user_id], ['id', $quote_id]])->first();
            $quote->quote_date = date("d M Y", strtotime($quote->created_at));
            $quote->vin_image = env('APP_URL') . '/storage/quotes/' . $quote->vin;
            $quote->make = $quote->make->name;
            $quote->model = $quote->model->name;
            $quote->year = $quote->year->name;

            $arr = [];

            $quoteItems = QuoteItem::where('quote_session_id', $quote->quote_id)->get();
            foreach ($quoteItems as $item) {
                $item->part_image = env('APP_URL') . '/storage/quotes/' . $item->part_image;
            }

            $arr['quote'] = $quote;
            $arr['items'] = $quoteItems;

            $response['data'] = $arr;
            $response['errors'] = false;
            $response['status_code'] = 200;
            return response()->json($response, 200);

        }
        catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}