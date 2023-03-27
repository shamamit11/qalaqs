<?php

namespace App\Http\Requests\Api\User\Auth;

use App\Http\Requests\ApiRequest;

class RegisterUserRequest extends ApiRequest
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
            'user_type' => 'required',
            'business_name' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'device_id' => 'nullable'
        ];
    }
}
