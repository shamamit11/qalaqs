<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use App\Services\Api\Vendor\VendorService;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    protected $vendor;

    public function __construct(VendorService $VendorService)
    {
        $this->vendor = $VendorService;
    }

    public function vendorDetail() {
        return $this->vendor->vendorDetail();
    }

    public function vendorStats() {
        return $this->vendor->vendorStats();
    }

    public function notification() {
        return $this->vendor->notification();
    }

    public function updateNotificationStatus(Request $request) {
        return $this->vendor->updateNotificationStatus($request);
    }
}
