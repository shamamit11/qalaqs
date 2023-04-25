<?php

namespace App\Http\Controllers\Courier;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $nav = 'dashboard';
        $sub_nav = '';
        $page_title = 'Courier Dashboard';
        return view('courier.dashboard.index', compact('nav', 'sub_nav', 'page_title'));
    }
}
