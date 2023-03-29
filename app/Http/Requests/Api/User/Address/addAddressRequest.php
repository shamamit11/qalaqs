<?php

namespace App\Http\Requests\Api\User\Address;

use App\Http\Requests\ApiRequest;

class addAddressRequest extends ApiRequest
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
            'name' => 'required',
            'building_name' => 'required',
            'street_name' => 'required',
            'city' => 'required',
            'country' => 'required',
            'mobile_no' => 'required',

        ];
    }
}
