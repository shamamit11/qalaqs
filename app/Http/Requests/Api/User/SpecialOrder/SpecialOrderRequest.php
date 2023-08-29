<?php

namespace App\Http\Requests\Api\User\SpecialOrder;

use App\Http\Requests\ApiRequest;

class SpecialOrderRequest extends ApiRequest
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
            'image' => '',
            'part_number' => 'required',
            'chasis_number' => 'required',
            'make_id' => 'required|exists:makes,id',
            'model_id' => 'required|exists:models,id',
            'year_id' => 'required|exists:years,id',
            'qty' => 'required',
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'address' => 'required',
            'city' => 'required',
            'country' => 'required'
        ];
    }
}
