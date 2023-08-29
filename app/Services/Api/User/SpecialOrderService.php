<?php
namespace App\Services\Api\User;
use App\Models\SpecialOrder;
use App\Traits\StoreImageTrait;
use Illuminate\Support\Facades\Mail;

class SpecialOrderService
{
    use StoreImageTrait;
    public function createSpecialOrder($request) {
        try { 
            $order = new SpecialOrder();
            $order->image = isset($request['image']) ? $this->StoreImage($request['image'], '/specialorders/') : null;
            $order->part_number = $request['part_number'];
            $order->chasis_number = $request['chasis_number'];
            $order->make_id = $request['make_id'];
            $order->model_id = $request['model_id'];
            $order->year_id = $request['year_id'];
            $order->qty = $request['qty'];
            $order->name = $request['name'];
            $order->email = $request['email'];
            $order->mobile = $request['mobile'];
            $order->address = $request['address'];
            $order->city = $request['city'];
            $order->country = $request['country'];
            $order->save();

            $emailData = [
                'name' => $request['name']
            ];

            // Mail::send('email.client.part_request', $emailData, function ($message) use($order) {
            //     $message->to($order->email);
            //     $message->subject('Qalaqs: Part Request');
            // });

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