<?php

namespace App\Http\Requests\Admin;
use App\Http\Requests\ApiRequest;

class YearRequest extends ApiRequest
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
            'id' => 'numeric|nullable',
            'name' => 'required|digits:4',
            'status' => 'nullable',
        ];
    }
}
