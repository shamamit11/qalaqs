<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Services\Api\User\AddressService;
use Illuminate\Http\Request;
use App\Http\Requests\Api\User\Address\AddressRequest;

class AddressController extends Controller
{
    protected $address;

    public function __construct(AddressService $AddressService)
    {
        $this->address = $AddressService;
    }

    function list() {
        return $this->address->list();
    }

    public function addEdit(AddressRequest $request) {
        return $this->address->addEdit($request->validated());
    }

    public function getAddress($id) {
        return $this->address->getAddress($id);
    }

    public function deleteAddress($id) {
        return $this->address->deleteAddress($id);
    }

    

}
