<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Services\Vendor\ReviewService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    protected $review;

    public function __construct(ReviewService $ReviewService)
    {
        $this->review = $ReviewService;
    }

    public function index(Request $request)
    {
        $nav = 'review';
        $sub_nav = '';
        $per_page = 100;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $page_title = 'Client Reviews';
        $result = $this->review->list($per_page, $page, $q);
        return view('vendor.review.index', compact('nav', 'sub_nav', 'page_title'), $result);
    }
}
