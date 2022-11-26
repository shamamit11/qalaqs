<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
//se App\Http\Requests\Admin\SupplierRequest;
use App\Services\Admin\SupplierService;
use Illuminate\Http\Request;

use App\Models\Supplier;

class SupplierController extends Controller
{
    protected $supplier;

    public function __construct(SupplierService $SupplierService)
    {
        $this->supplier = $SupplierService;
    }

    public function index(Request $request)
    {
        $nav = 'supplier';
        $sub_nav = '';
        $per_page = 10;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $page_title = 'Product Suppliers';
        $result = $this->supplier->List($per_page, $page, $q);
        return view('admin.supplier.index', compact('nav', 'sub_nav', 'page_title'), $result);
    }

    public function status(Request $request)
    {
        $this->supplier->status($request);
    }

    // public function addEdit(Request $request)
    // {
    //     $nav = 'supplier';
    //     $sub_nav = '';
    //     $id = ($request->id) ? $request->id : 0;
    //     $page_title = 'Product Suppliers';
    //     $data['title'] = ($id == 0) ? "Add Supplier" : "Edit Supplier";
    //     $data['action'] = route('admin-supplier-addaction');
    //     $data['row'] = Supplier::where('id', $id)->first();
    //     return view('admin.supplier.add', compact('nav', 'sub_nav', 'page_title'), $data);
    // }

    // public function addAction(SupplierRequest $request)
    // {
    //     return $this->supplier->store($request->validated());
    // }

    public function delete(Request $request)
    {
        echo $this->supplier->delete($request);
    }
}
