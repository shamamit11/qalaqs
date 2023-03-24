<?php

namespace App\Http\Requests\Api\Vendor\Auth;

use App\Http\Requests\ApiRequest;

class RegisterVendorRequest extends ApiRequest
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
            'business_name' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required',
            'email' => 'required|email|unique:vendors,email',
            'password' => 'required',
            'account_type' => 'required',
            'image' => 'required|image',
        ];
    }
}
