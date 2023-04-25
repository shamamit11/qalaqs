<?php

namespace App\Http\Requests\Admin;
use App\Http\Requests\ApiRequest;

class CourierRequest extends ApiRequest
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
            'id' => 'integer|nullable',
            'account_type' => 'required',
            'business_name' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'designation' => 'required',
            'mobile' => 'required',
            'phone' => 'required',
            'image' => '',
            'license_image' => '',
            'address' => 'required',
            'city' => 'required',
            'email' => 'required',
            'password' => ($this->id == 0 || $this->id == '') ? 'required' : '',
            'status' => 'nullable',
        ];
    }
}
