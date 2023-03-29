<?php

namespace App\Http\Requests\Api\User\Cart;

use App\Http\Requests\ApiRequest;

class PromoRequest extends ApiRequest
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
            'code' => 'required',
            'cart_session_id' => 'required'
        ];
    }
}
