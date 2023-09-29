<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Services\Api\User\FeaturedService;

class AutoServiceController extends Controller
{
    protected $service;

    public function __construct(FeaturedService $FeaturedService)
    {
        $this->service = $FeaturedService;
    }

    public function garage()
    {
        return $this->service->garage();
    }

    public function recovery()
    {
        return $this->service->recovery();
    }

    public function autoservice()
    {
        return $this->service->autoservice();
    }

    public function auction()
    {
        return $this->service->auction();
    }

}