<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $nav = '';
        $sub_nav = '';
        $page_title = 'Dashboard';
        $data = array();
        if (Auth::guard('supplier')->user()->admin_approved == 1) {
            return view('supplier.dashboard.index', compact('nav', 'sub_nav', 'page_title'), $data);
        } else {
            return view('supplier.dashboard.pending', compact('nav', 'sub_nav', 'page_title'), $data);
        }
    }
}
