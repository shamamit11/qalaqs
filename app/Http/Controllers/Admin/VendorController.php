<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VendorRequest;
use App\Models\Bank;
use App\Models\VendorReview;
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
        $per_page = 100;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $page_title = 'Vendors';
        $result = $this->vendor->list($per_page, $page, $q);
        return view('admin.vendors.index', compact('nav', 'sub_nav', 'page_title'), $result);
    }

    public function status(Request $request)
    {
        $this->vendor->status($request);
    }

    public function view(Request $request)
    {
        $nav = 'vendor';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $page_title = 'Vendor Details';
        $data['title'] = ($id == 0) ? "Add Vendor" : "View Vendor";
        $data['row'] = Vendor::where('id', $id)->first();
        $data['reviews'] = VendorReview::where('vendor_id', $id)->get();
        return view('admin.vendors.view', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function delete(Request $request)
    {
        return $this->vendor->delete($request);
    }

    public function addEdit(Request $request)
    {
        $nav = 'vendor';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $data['title'] = $page_title = ($id == 0) ? "Add Vendor" : "Edit Vendor";
        $data['action'] = route('admin-vendor-addaction');
        $data['row'] = Vendor::where('id', $id)->first();
        $data['bank'] = Bank::where('vendor_id', $id)->first();
        return view('admin.vendors.add', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function addAction(VendorRequest $request)
    {
        return $this->vendor->store($request->validated());
    }

    public function imageDelete(Request $request) {
        echo $this->vendor->imageDelete($request);
    }
}
