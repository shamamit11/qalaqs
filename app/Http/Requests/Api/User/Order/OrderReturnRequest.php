<?php

namespace App\Http\Requests\Api\User\Order;

use App\Http\Requests\ApiRequest;

class OrderReturnRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'order_id' => 'required',
            'order_item_id' => 'required',
            'product_id' => 'required',
            'vendor_id' => 'required',
            'reason' => 'required'
        ];
    }
}
