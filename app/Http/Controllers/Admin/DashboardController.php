<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $nav = 'dashboard';
        $sub_nav = '';
        $data['page_title'] = 'Dashboard';
        return view('admin.dashboard.index', compact('nav', 'sub_nav'), $data);
    }
}
