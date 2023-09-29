<?php

namespace App\Http\Requests\Api\User\Quote;

use App\Http\Requests\ApiRequest;

class TempQuoteItemRequest extends ApiRequest
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
            'quote_session_id' => 'required',
            'user_id' => '',
            'part_image' => '',
            'part_name' => 'required',
            'part_number' => 'required',
            'qty' => 'required',
        ];
    }
}
