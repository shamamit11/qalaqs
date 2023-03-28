<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Services\Api\User\AddressService;
use Illuminate\Http\Request;
use App\Http\Requests\Api\User\Address\addAddressRequest;

class AddressController extends Controller
{
    protected $address;

    public function __construct(AddressService $AddressService)
    {
        $this->address = $AddressService;
    }

    function addAddress(addAddressRequest $request) {
        return $this->address->addAddress($request->validated());
    }

    function list($user_id) {
        return $this->address->list($user_id);
    }

}
