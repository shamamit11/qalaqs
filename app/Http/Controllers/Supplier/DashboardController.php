<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Session;

class DashboardController extends Controller
{
    public function index()
    {
        // $session = session()->all();
        // dd($session);
        $nav = '';
        $sub_nav = '';
        $page_title = 'Dashboard';
        $data = array();
        if (Session::get('user_name') == 1) {
            return view('supplier.dashboard.index', compact('nav', 'sub_nav', 'page_title'), $data);
        } else {
            return view('supplier.dashboard.pending', compact('nav', 'sub_nav', 'page_title'), $data);
        }
    }
}
