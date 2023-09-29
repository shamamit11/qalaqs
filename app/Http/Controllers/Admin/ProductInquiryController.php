<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductInquiry;
use App\Services\Admin\ProductInquiryService;
use Illuminate\Http\Request;

class ProductInquiryController extends Controller
{
    protected $inquiry;

    public function __construct(ProductInquiryService $ProductInquiryService)
    {
        $this->inquiry = $ProductInquiryService;
    }

    public function index(Request $request)
    {
        $nav = 'inquiry';
        $sub_nav = '';
        $per_page = 100;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $page_title = 'Product Inquiries';
        $result = $this->inquiry->list($per_page, $page, $q);
        return view('admin.productinquiry.index', compact('nav', 'sub_nav', 'page_title'), $result);
    }

    public function view(Request $request)
    {
        $nav = 'inquiry';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $data['title'] = $page_title =($id == 0) ? "View Product Inquiry" : "View Product Inquiry";
        $data['row'] = $inquiry = ProductInquiry::where('id', $id)->first();
        return view('admin.productinquiry.view', compact('nav', 'sub_nav', 'page_title'), $data);
    }
}
