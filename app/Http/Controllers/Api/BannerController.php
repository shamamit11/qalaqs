<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\BannerService;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    protected $banner;

    public function __construct(BannerService $BannerService)
    {
        $this->banner = $BannerService;
    }

    function list() {
        return $this->banner->list();
    }

}
