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
            'main_image' => 'required|image',
            'image_01' => 'nullable|image',
            'image_02' => 'nullable|image',
            'image_03' => 'nullable|image',
            'image_04' => 'nullable|image',
            'title' => 'required',
            'part_number' => 'required',
            'sku' => 'required',
            'make_id' => 'required|exists:makes,id',
            'model_id' => 'required|exists:models,id',
            'year_id' => 'required|exists:years,id',
            'engine_id' => 'required|exists:engines,id',
            'manufacturer' => 'required',
            'brand_id' => 'nullable|exists:brands,id',
            'part_type' => 'required',
            'market' => 'required',
            'warranty' => 'required',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'price' => 'required|numeric',
            'discount' => 'nullable|integer',
            'stock'=>'required|integer',
            'weight'=>'required|numeric',
            'height'=>'required|numeric',
            'width'=>'required|numeric',
            'length'=>'required|numeric',
        ];
    }
}
