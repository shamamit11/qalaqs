<?php

namespace App\Http\Controllers\Api\User;
use App\Http\Controllers\Controller;
use App\Services\Api\User\ProductInquiryService;
use Illuminate\Http\Request;

class ProductInquiryController extends Controller
{
    protected $inquiry;

    public function __construct(ProductInquiryService $ProductInquiryService)
    {
        $this->inquiry = $ProductInquiryService;
    }

    public function inquiry(Request $request) {
        return $this->inquiry->create($request);
    }
}
