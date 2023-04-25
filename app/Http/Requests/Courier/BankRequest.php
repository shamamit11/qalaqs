<?php

namespace App\Http\Requests\Courier;
use App\Http\Requests\ApiRequest;

class BankRequest extends ApiRequest
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
            'bank_name' => 'required',
            'account_name' => 'required',
            'account_no' => 'required',
            'iban' => 'required'
        ];
    }
}
