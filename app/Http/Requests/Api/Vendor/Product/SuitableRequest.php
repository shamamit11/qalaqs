<?php

namespace App\Http\Requests\Api\Vendor\Product;

use App\Http\Requests\ApiRequest;

class SuitableRequest extends ApiRequest
{
    /**
     * Determine if the vendor is authorized to make this request.
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
            'product_id' => 'required|exists:products,id',
            'make_id' => 'required|exists:makes,id',
            'model_id' => 'required|exists:models,id',
            'year_id' => 'required|exists:years,id',
            'engine_id' => ''
        ];
    }
}
