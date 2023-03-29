<?php

namespace App\Http\Requests\Api\User\Order;

use App\Http\Requests\ApiRequest;

class PaymentRequest extends ApiRequest
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
            'card_name' => 'required',
            'card_number' => 'required',
            'expiry_month' => 'required',
            'expiry_year' => 'required',
            'cvc' => 'required',
            'cart_session_id' => 'required',
            'total_amount' => 'required'
        ];
    }
}
