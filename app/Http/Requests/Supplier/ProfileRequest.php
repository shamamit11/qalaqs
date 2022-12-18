<?php

namespace App\Http\Requests\Supplier;
use App\Http\Requests\ApiRequest;

class ProfileRequest extends ApiRequest
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
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zipcode' => 'required',
            'country_id' => 'required|exists:countries,id',
            'phone' => 'required',
            'mobile' => 'required',
        ];
    }
}
