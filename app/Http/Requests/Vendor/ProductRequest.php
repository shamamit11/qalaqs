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
            'part_number' => '',
            'sku' => '',
            'make_id' => '',
            'model_id' => '',
            'year_id' => '',
            'engine_id' => '',
            'manufacturer' => '',
            'origin' => '',
            'brand_id' => '',
            'part_type' => '',
            'market' => '',
            'warranty' => '',
            'category_id' => '',
            'subcategory_id' => '',
            'price' => 'required|numeric',
            'discount' => 'nullable|integer',
            'stock'=>'required',
            'weight'=>'',
            'height'=>'',
            'width'=>'',
            'length'=>'',
        ];
    }
}
