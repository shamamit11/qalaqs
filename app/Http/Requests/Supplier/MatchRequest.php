<?php

namespace App\Http\Requests\Supplier;

use App\Http\Requests\ApiRequest;

class MatchRequest extends ApiRequest
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
            'product_id' => 'numeric|required',
            'engine_id' => 'required|exists:product_engines,id',
        ];
    }
}
