<?php

namespace App\Http\Requests\Api\Vendor\Order;

use App\Http\Requests\ApiRequest;

class OrderStatusRequest extends ApiRequest
{
    /**
     * Determine if the vendor is authorized to make this request.
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
            'order_item_id' => 'required|exists:order_items,id',
            'status_id' => 'required|exists:order_statuses,id'
        ];
    }
}
