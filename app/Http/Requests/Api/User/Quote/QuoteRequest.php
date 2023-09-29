<?php

namespace App\Http\Requests\Api\User\Quote;

use App\Http\Requests\ApiRequest;

class QuoteRequest extends ApiRequest
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
            'quote_id' => 'required',
            'user_id' => '',
            'part_type' => 'required',
            'make_id' => 'required',
            'model_id' => 'required',
            'year_id' => 'required',
            'engine' => '',
            'vin' => '',
        ];
    }
}
