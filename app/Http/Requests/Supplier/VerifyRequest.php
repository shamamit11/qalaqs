<?php

namespace App\Http\Requests\Supplier;
use App\Http\Requests\ApiRequest;

class VerifyRequest extends ApiRequest  
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
            'verification_code' => 'required|exists:suppliers,verification_code',
            'email' => 'required|email|exists:suppliers,email',
        ];
    }
}
