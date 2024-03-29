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
            'main_image' => '',
            'image_01' => '',
            'image_02' => '',
            'image_03' => '',
            'image_04' => '',
            'title' => 'required',
            'part_number' => '',
            'sku' => '',
            'make_id' => 'required',
            'model_id' => 'required',
            'year_id' => 'required',
            'engine_id' => '',
            'manufacturer' => '',
            'origin' => '',
            'brand_id' => '',
            'part_type' => '',
            'market' => '',
            'warranty' => '',
            'category_id' => 'required',
            'subcategory_id' => 'required',
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
