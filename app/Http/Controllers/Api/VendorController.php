<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\VendorService;
use Illuminate\Http\Request;
use App\Http\Requests\Api\VendorRequest;

class VendorController extends Controller
{
    protected $vendor;

    public function __construct(VendorService $VendorService)
    {
        $this->vendor = $VendorService;
    }

    function add (VendorRequest $request) {
        return $this->vendor->store($request->validated());
    }

}
