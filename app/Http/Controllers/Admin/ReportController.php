<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $report;

    public function __construct(ReportService $ReportService)
    {
        $this->report = $ReportService;
    }

    public function vendors(Request $request)
    {
        $nav = 'report';
        $sub_nav = '';
        $per_page = 200;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $page_title = 'Vendor Reports';
        $result = $this->report->vendors($per_page, $page, $q);
        return view('admin.report.vendors', compact('nav', 'sub_nav', 'page_title'), $result);
    }
}
