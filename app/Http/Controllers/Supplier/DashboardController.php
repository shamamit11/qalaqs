<?php

namespace App\Http\Controllers\supplier;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $nav = '';
        $sub_nav = '';
        $data['page_title'] = 'Dashboard';
        return view('supplier.dashboard.index', compact('nav', 'sub_nav'), $data);
    }
}
