<?php

namespace App\Http\Requests\Supplier;

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
            'id' => 'numeric|nullable',
            'sku' => 'required',
            'part_type' => 'required',
            'part_number' => 'required',
            'manufacturer' => 'required',
            'name' => 'required',
            'image' => 'sometimes',
            'category_id' => 'required|exists:product_categories,id',
            'subcategory_id' => 'required|exists:product_sub_categories,id',
            'brand_id' => 'required|exists:product_brands,id',
            'make_id' => 'required|exists:product_makes,id',
            'model_id' => 'required|exists:product_models,id',
            'year_id' => 'required|exists:product_years,id',
            'engine_id' => 'required|exists:product_engines,id',
            'warranty' => 'sometimes',
            'price' => 'required',
            'status' => 'nullable',
        ];
    }
}
