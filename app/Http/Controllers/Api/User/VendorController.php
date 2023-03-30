<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Vendor\VendorReviewRequest;
use App\Services\Api\User\VendorService;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    protected $vendor;

    public function __construct(VendorService $VendorService)
    {
        $this->vendor = $VendorService;
    }

    public function vendorDetail($vendor_id) {
        return $this->vendor->vendorDetail($vendor_id);
    }

    public function addReview(VendorReviewRequest $request) {
        return $this->vendor->addReview($request);
    }
}
