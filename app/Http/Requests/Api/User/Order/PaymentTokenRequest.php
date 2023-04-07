<?php

namespace App\Http\Requests\Api\User\Order;

use App\Http\Requests\ApiRequest;

class PaymentTokenRequest extends ApiRequest
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
            'shipping_address_id' => 'required',
            'total_amount' => 'required',
        ];
    }
}
