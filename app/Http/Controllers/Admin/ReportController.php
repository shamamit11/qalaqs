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

    public function make(Request $request)
    {
        $nav = 'report';
        $sub_nav = '';
        $per_page = 20;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $page_title = ' Reports of make';
        $result = $this->report->make($per_page, $page, $q);
        return view('admin.report.make', compact('nav', 'sub_nav', 'page_title'), $result);
    }
}
