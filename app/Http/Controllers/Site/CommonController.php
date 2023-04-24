<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\Site\CommonService;

class CommonController extends Controller
{
    protected $common;

    public function __construct(CommonService $CommonService)
    {
        $this->common = $CommonService;
    }
    public function verifyVendorAccount($token)
    {
        return $this->common->verifyVendorAccount($token);
    }

    public function verifyUserAccount($token)
    {
        return $this->common->verifyUserAccount($token);
    }

    public function accountVerified() {
        return view('site.verification.verified');
    }

    public function accountNotVerified() {
        return view('site.verification.not-verified');
    }
}
