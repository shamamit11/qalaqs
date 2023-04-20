<?php

namespace App\Http\Requests\Api\User\Address;

use App\Http\Requests\ApiRequest;

class AddressRequest extends ApiRequest
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
            'id' => 'required',
            'name' => 'required',
            'building' => 'required',
            'street_name' => 'required',
            'city' => 'required',
            'country' => 'required',
            'mobile' => 'required',
            'is_default' => '',
        ];
    }
}
