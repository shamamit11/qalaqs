<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $nav = 'dashboard';
        $sub_nav = '';
        $page_title = 'Vendor Dashboard';
        return view('vendor.dashboard.index', compact('nav', 'sub_nav', 'page_title'));
    }
}
