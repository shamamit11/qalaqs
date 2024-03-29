<?php

namespace App\Http\Requests\Admin;
use App\Http\Requests\ApiRequest;

class VendorRequest extends ApiRequest
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
            'vendor_code' => '',
            'business_name' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required',
            'image' => 'nullable',
            'license_image' => 'required',
            'address' => 'required',
            'city' => 'required',
            'email' => ($this->id == 0 || $this->id == '') ? 'required|email|unique:vendors,email' : '',
            'password' => ($this->id == 0 || $this->id == '') ? 'required' : '',
            'verification_code' => '',
            'email_verified' => '',
            'admin_approved' => '',
            'status' => '',
            'account_type' => 'required',
            'device_id' => '',
            'bank_name' => '',
            'account_name' => '',
            'account_no' => '',
            'iban' => '',
            'bank_image' => ''
        ];
    }
}
