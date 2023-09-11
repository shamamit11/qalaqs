<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderReturn;
use App\Models\Product;
use App\Models\SpecialOrder;

use App\Models\User;
use App\Models\Vendor;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $nav = 'dashboard';
        $sub_nav = '';
        $page_title = 'Dashboard';
        $data['total_special_requests'] = SpecialOrder::count();
        $data['today_special_requests'] = SpecialOrder::whereDate('created_at', Carbon::today())->count();
        $data['total_orders'] = Order::count();
        $data['today_orders'] = Order::whereDate('created_at', Carbon::today())->count();
        $data['total_returns'] = OrderReturn::count();
        $data['today_returns'] = OrderReturn::whereDate('created_at', Carbon::today())->count();
        $data['today_sales'] = Order::whereDate('created_at', Carbon::today())->sum('grand_total');
        $data['total_sales'] = Order::sum('grand_total');
        $data['vendors_seller'] = Vendor::whereDate('created_at', Carbon::today())->where('account_type', 'Seller')->count();
        $data['vendors_garage'] = Vendor::whereDate('created_at', Carbon::today())->where('account_type', 'Garage')->count();
        $data['approved_vendors'] = Vendor::where('admin_approved', 1)->count();
        $data['pending_vendors'] = Vendor::where('admin_approved', 0)->count();
        $data['user_individual'] = User::whereDate('created_at', Carbon::today())->where('user_type', 'I')->count();
        $data['user_garage'] = User::whereDate('created_at', Carbon::today())->where('user_type', 'G')->count();
        $data['total_user_individual'] = User::where('user_type', 'I')->count();
        $data['total_user_garage'] = User::where('user_type', 'G')->count();

        $data['topSellingProducts'] = $topSellingProducts = DB::table('products')
            ->select('products.id', DB::raw('MAX(products.title) as title'), DB::raw('MAX(makes.name) as make'), DB::raw('SUM(order_items.item_count) as total_sales'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('makes', 'makes.id', '=', 'products.make_id')
            ->groupBy('products.id')
            ->orderByDesc('total_sales')
            ->limit(10)
            ->get();
        
        $totalSales = $topSellingProducts->sum('total_sales');
        
        foreach($topSellingProducts as $tsp) {
            $tsp->percentage = ($tsp->total_sales / $totalSales) * 100;
        }

        $data['topSellingVendors'] = $topSellingVendors = Vendor::select('vendors.id', 'vendors.business_name', DB::raw('SUM(order_items.item_count) as total_sales'))
            ->join('order_items', 'vendors.id', '=', 'order_items.vendor_id')
            ->groupBy('vendors.id', 'vendors.business_name')
            ->orderByDesc('total_sales')
            ->limit(10) // You can adjust this limit as needed to get the top N selling vendors
            ->get();

        return view('admin.dashboard.index', compact('nav', 'sub_nav', 'page_title'), $data);
    }
}
