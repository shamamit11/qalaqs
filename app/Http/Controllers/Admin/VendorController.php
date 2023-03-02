<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
//se App\Http\Requests\Admin\VendorRequest;
use App\Services\Admin\VendorService;
use Illuminate\Http\Request;

use App\Models\Vendor;

class VendorController extends Controller
{
    protected $vendor;

    public function __construct(VendorService $VendorService)
    {
        $this->vendor = $VendorService;
    }

    public function index(Request $request)
    {
        $nav = 'vendor';
        $sub_nav = '';
        $per_page = 10;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $page_title = 'Vendors';
        $result = $this->vendor->List($per_page, $page, $q);
        return view('admin.vendor.index', compact('nav', 'sub_nav', 'page_title'), $result);
    }

    public function status(Request $request)
    {
        $this->vendor->status($request);
    }

    // public function addEdit(Request $request)
    // {
    //     $nav = 'vendor';
    //     $sub_nav = '';
    //     $id = ($request->id) ? $request->id : 0;
    //     $page_title = 'Product Vendors';
    //     $data['title'] = ($id == 0) ? "Add Vendor" : "Edit Vendor";
    //     $data['action'] = route('admin-vendor-addaction');
    //     $data['row'] = Vendor::where('id', $id)->first();
    //     return view('admin.vendor.add', compact('nav', 'sub_nav', 'page_title'), $data);
    // }

    // public function addAction(VendorRequest $request)
    // {
    //     return $this->vendor->store($request->validated());
    // }

    public function delete(Request $request)
    {
        return $this->vendor->delete($request);
    }
}
