<?php

namespace App\Http\Requests\Api\Vendor\Product;

use App\Http\Requests\ApiRequest;

class ProductRequest extends ApiRequest
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
            'id' => 'required|integer',
            'main_image' => 'required',
            'image_01' => 'required',
            'image_02' => 'required',
            'image_03' => 'required',
            'image_04' => 'required',
            'title' => 'required',
            'part_number' => 'nullable',
            'sku' => 'nullable',
            'make_id' => 'nullable|exists:makes,id',
            'model_id' => 'nullable|exists:models,id',
            'year_id' => 'nullable|exists:years,id',
            'engine_id' => 'nullable|exists:engines,id',
            'manufacturer' => 'nullable',
            'origin' => 'nullable',
            'brand_id' => 'nullable|exists:brands,id',
            'part_type' => 'nullable',
            'market' => 'nullable',
            'warranty' => 'nullable',
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'price' => 'required|numeric',
            'discount' => 'nullable|integer',
            'stock'=>'required|integer',
            'weight'=>'nullable',
            'height'=>'nullable',
            'width'=>'nullable',
            'length'=>'nullable',
        ];
    }
}
