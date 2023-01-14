<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\ApiRequest;

class ProductRequest extends ApiRequest
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
            'product_type' => 'required',
            'category_id' => 'required|exists:product_categories,id',
            'subcategory_id' => 'required|exists:product_sub_categories,id',
            'make_id' => 'required|exists:product_makes,id',
            'model_id' => 'required|exists:product_models,id',
            'year_id' => 'required|exists:product_years,id',
            'engine_id' => 'required|exists:product_engines,id',
        ];
    }
}
