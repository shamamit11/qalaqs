<?php

namespace App\Http\Requests\Api\Vendor\Auth;

use App\Http\Requests\ApiRequest;

class VendorMakeRequest extends ApiRequest
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
            'vendor_id' => 'required',
            'make_id' => 'required',
            'year_from_id'=> 'required',
            'year_to_id'=> 'required',
            'part_type'=> 'required',
            'market'=> 'required',
        ];
    }
}
