<?php

namespace App\Http\Requests\Admin;
use App\Http\Requests\ApiRequest;

class RecoveryRequest extends ApiRequest
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
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'logo' => '',
            'image' => 'required',
            'map' => '',
            'description' => 'required',
            'status' => 'nullable',
        ];
    }
}
