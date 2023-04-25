<?php

namespace App\Http\Requests\Api\User\Order;

use App\Http\Requests\ApiRequest;

class OrderRequest extends ApiRequest
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
            'cart_session_id' => 'required',
            'shipping_address_id' => 'required',
            'shipping_charge' => 'required',
            'transaction_id' => 'required',
            'payment_method' => 'required',
        ];
    }
}
