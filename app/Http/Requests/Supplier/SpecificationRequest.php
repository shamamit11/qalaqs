<?php

namespace App\Http\Requests\Supplier;

use App\Http\Requests\ApiRequest;

class SpecificationRequest extends ApiRequest
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
            'product_id' => 'integer|required',
            'specification_id' => 'required',
            'specification_id.*' => 'required',
            'specification_name' => 'required',
            'specification_name.*' => 'required',
            'specification_value' => 'required',
            'specification_value.*' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'specification_name.required' => 'The specification name field is required.',
            'specification_name.*.required' => 'The specification name field is required.',
            'specification_value.required' => 'The specification value field is required.',
            'specification_value.*.required' => 'The specification value field is required.',
        ];
    }

}
