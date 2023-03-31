<?php

namespace App\Http\Requests\Api\User\Product;

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
            'type_id' => 'required|exists:types,id',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'make_id' => 'required|exists:makes,id',
            'model_id' => 'required|exists:models,id',
            'year_id' => 'required|exists:years,id',
            'engine_id' => 'required|exists:engines,id',
        ];
    }
}
