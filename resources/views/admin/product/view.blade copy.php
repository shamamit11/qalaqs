@extends('admin.layout')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h3>{{ $page_title }}</h3> 
                                    <h4> 
                                        <span class="badge bg-primary">Total Views: {{ $views->views }}</span>
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="mb-3">
                                                <label class="form-label"> Title</label>
                                                <input type="text" class="form-control"
                                                    value="{{ isset($row->title) ? $row->title : '' }}"
                                                    readonly>
                                            </div>

                                            
                                            <div class="mb-3">
                                                <label class="form-label"> Vendor</label>
                                                <input type="text" class="form-control"
                                                    value="{{ isset($row->vendor_id) ? $row->vendor->business_name : '' }}"
                                                    readonly>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label"> Category</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ isset($row->category_id) ? $row->category->name : '' }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label"> Sub Category</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ isset($row->subcategory_id) ? $row->subcategory->name : '' }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label"> Brand</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ isset($row->brand_id) ? $row->brand->name : '' }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label"> Part Type</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ isset($row->part_type) ? $row->part_type : '' }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label"> Market</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ isset($row->market) ? $row->market : '' }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label"> Warranty</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ isset($row->warranty) ? $row->warranty : '' }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Status</label>
                                                        <label class="switch">
                                                            <input type="checkbox" class="switch-input"
                                                                value="1"
                                                                {{ (isset($row->status) && $row->status == 1) || !isset($row->status) ? 'checked' : '' }} disabled/>
                                                            <span class="switch-label" data-on="Show" data-off="Hide"></span> 
                                                            {{-- <span class="switch-handle"></span> --}}
                                                        </label> 
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Admin Approval</label>
                                                        <label class="switch">
                                                            <input type="checkbox" class="switch-input"
                                                                value="1"
                                                                {{ (isset($row->admin_approved) && $row->admin_approved == 1) || !isset($row->admin_approved) ? 'checked' : '' }} disabled/>
                                                            <span class="switch-label" data-on="Approved" data-off="Pending"></span>
                                                            {{-- <span class="switch-handle"></span> </label> --}}
                                                    </div>
                                                </div>
                                            </div>

                                            

                                            
                                        </div>
                                        <div class="col-md-7">
                                            <div class="mb-3 row">
                                                <div class="col-md-3">
                                                    <label class="form-label"> Part#</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ isset($row->part_number) ? $row->part_number : '' }}"
                                                        readonly>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label"> SKU</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ isset($row->sku) ? $row->sku : '' }}"
                                                        readonly>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label"> Manufacturer</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ isset($row->manufacturer) ? $row->manufacturer : '' }}"
                                                        readonly>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label"> Origin</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ isset($row->origin) ? $row->origin : '' }}"
                                                        readonly>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <div class="col-md-3">
                                                    <label class="form-label"> Make</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ isset($row->make_id) ? $row->make->name : '' }}"
                                                        readonly>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label"> Model</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ isset($row->model_id) ? $row->model->name : '' }}"
                                                        readonly>
                                                    
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label"> Year</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ isset($row->year_id) ? $row->year->name : '' }}"
                                                        readonly>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label"> Engine</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ isset($row->engine_id) ? $row->engine->name : '' }}"
                                                        readonly>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <div class="col-md-3">
                                                    <label class="form-label"> Weight</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ isset($row->weight) ? $row->weight : '' }}"
                                                        readonly>
                                                   
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label"> Height</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ isset($row->height) ? $row->height : ''}}"
                                                        readonly>
                                                    
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label"> Length</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ isset($row->length) ? $row->length : ''}}"
                                                        readonly>
                                                    
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label"> Width</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ isset($row->width) ? $row->width : '' }}"
                                                        readonly>
                                                    
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label"> Price</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ isset($row->price) ? $row->price : '' }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label"> Discount</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ isset($row->discount) ? $row->discount : '' }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label"> Stock</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ isset($row->stock) ? $row->stock : '' }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.includes.footer')
        </div>
    @endsection
    @section('footer-scripts')
        @include('admin.make.js.add')
    @endsection
