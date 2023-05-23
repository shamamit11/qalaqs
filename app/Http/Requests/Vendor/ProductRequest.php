<?php

namespace App\Http\Requests\Vendor;
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
            'id' => 'required|integer',
            'main_image' => 'required',
            'image_01' => 'required',
            'image_02' => 'required',
            'image_03' => 'required',
            'image_04' => 'required',
            'title' => 'required',
            'part_number' => 'required',
            'sku' => 'nullable',
            'make_id' => 'nullable|exists:makes,id',
            'model_id' => 'nullable|exists:models,id',
            'year_id' => 'nullable|exists:years,id',
            'engine_id' => 'nullable|exists:engines,id',
            'manufacturer' => 'nullable',
            'origin' => 'nullable',
            'brand_id' => 'nullable|exists:brands,id',
            'part_type' => 'required',
            'market' => 'nullable',
            'warranty' => 'nullable',
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'price' => 'required|numeric',
            'discount' => 'nullable|integer',
            'stock'=>'required',
            'weight'=>'nullable',
            'height'=>'nullable',
            'width'=>'nullable',
            'length'=>'nullable',
        ];
    }
}
