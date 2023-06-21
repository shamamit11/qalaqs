@extends('admin.layout')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3>{{ isset($row->title) ? $row->title : '' }}</h3>
                                <h3>
                                    <span class="badge bg-primary">Total Views: {{ isset($views->views) ? $views->views : '0' }}</span>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="table-responsive table-bordered ">
                                            <table class="table table-striped mb-0 ">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row" width="200">Product Title</th>
                                                        <td>{{ isset($row->title) ? $row->title : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Vendor</th>
                                                        <td>{{ isset($row->vendor_id) ? $row->vendor->business_name : '' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Category</th>
                                                        <td>{{ isset($row->category_id) ? $row->category->name : '' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Sub Category</th>
                                                        <td>{{ isset($row->subcategory_id) ? $row->subcategory->name : '' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Brand</th>
                                                        <td>{{ isset($row->brand_id) ? $row->brand->name : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Part Type</th>
                                                        <td>{{ isset($row->part_type) ? $row->part_type : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Market</th>
                                                        <td>{{ isset($row->market) ? $row->market : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Warranty</th>
                                                        <td>{{ isset($row->warranty) ? $row->warranty : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Price</th>
                                                        <th scope="row" style="color:crimson">AED
                                                            {{ isset($row->price) ? $row->price : '' }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Discount</th>
                                                        <th scope="row">
                                                            {{ isset($row->discount) ? $row->discount : '0' }} %</th>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Stock</th>
                                                        <th scope="row">{{ isset($row->stock) ? $row->stock : '0' }}
                                                        </th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="table-responsive table-bordered ">
                                            <table class="table table-striped mb-0 ">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row" width="200">Part#</th>
                                                        <td>{{ isset($row->part_number) ? $row->part_number : '' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">SKU</th>
                                                        <td>{{ isset($row->sku) ? $row->sku : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Manufacturer</th>
                                                        <td>{{ isset($row->manufacturer) ? $row->manufacturer : '' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Origin</th>
                                                        <td>{{ isset($row->origin) ? $row->origin : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Make</th>
                                                        <td>{{ isset($row->make_id) ? $row->make->name : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Model</th>
                                                        <td>{{ isset($row->model_id) ? $row->model->name : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Year</th>
                                                        <td>{{ isset($row->year_id) ? $row->year->name : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Engine</th>
                                                        <td>{{ isset($row->engine_id) ? $row->engine->name : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Status</th>
                                                        <td>
                                                            @if($row->status == 1)
                                                                <span class="badge bg-success">{{ $row->status == 1 ? 'Active' : 'Inactive' }}</span>
                                                            @else
                                                                <span class="badge bg-secondary">{{ $row->status == 1 ? 'Active' : 'Inactive' }}</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Admin Approval</th>
                                                        <td>
                                                            @if($row->admin_approved == 1)
                                                            <span class="badge bg-success">{{ $row->admin_approved == 1 ? 'Approved' : 'Pending' }}</span>
                                                        @else
                                                            <span class="badge bg-secondary">{{ $row->admin_approved == 1 ? 'Approved' : 'Pending' }}</span>
                                                        @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <h4 class="mb-2 header-title text-muted">Specification</h4>
                                    <div class="table-responsive table-bordered ">
                                        <table class="table table-striped mb-0 ">
                                            <thead>
                                                <tr>
                                                    <th>Weight</th>
                                                    <th>Height</th>
                                                    <th>Length</th>
                                                    <th>Width</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ isset($row->weight) ? $row->weight : '' }}</td>
                                                    <td>{{ isset($row->height) ? $row->height : '' }}</td>
                                                    <td>{{ isset($row->length) ? $row->length : '' }}</td>
                                                    <td>{{ isset($row->width) ? $row->width : '' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                {{-- <div class="row mt-3">
                                    <h4 class="mb-2 header-title text-muted">Product Images</h4>
                                    <div class="table-responsive table-bordered ">
                                        <table class="table table-striped mb-0 ">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div style="width:270px; padding:10px; background-color: #fff; border-radius: 10px;">
                                                            <img src="{{ asset('/storage/product/'.$row->main_image)}}" width="250">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div style="width:270px; padding:10px; background-color: #fff; border-radius: 10px;">
                                                            <img src="{{ asset('/storage/product/'.$row->image_01)}}" width="250">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div style="width:270px; padding:10px; background-color: #fff; border-radius: 10px;">
                                                            <img src="{{ asset('/storage/product/'.$row->image_02)}}" width="250">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div style="width:270px; padding:10px; background-color: #fff; border-radius: 10px;">
                                                            <img src="{{ asset('/storage/product/'.$row->image_03)}}" width="250">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div style="width:270px; padding:10px; background-color: #fff; border-radius: 10px;">
                                                            <img src="{{ asset('/storage/product/'.$row->image_04)}}" width="250">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div> --}}
                                @if(count($matches) > 0)
                                    <div class="row mt-3">
                                        <h4 class="mb-2 header-title text-muted">Suitable For</h4>
                                        <div class="table-responsive table-bordered ">
                                            <table class="table table-striped mb-0 ">
                                                <thead>
                                                    <tr>
                                                        <th>Make</th>
                                                        <th>Model</th>
                                                        <th>Year</th>
                                                        <th>Engine</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($matches as $val)
                                                        <tr>
                                                            <td>{{ isset($val->make_id) ? $val->make->name : '' }}</td>
                                                            <td>{{ isset($val->model_id) ? $val->model->name : '' }}</td>
                                                            <td>{{ isset($val->year_id) ? $val->year->name : '' }}</td>
                                                            <td>{{ isset($val->engine_id) ? $val->engine->name : '' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif

                                @if(count($reviews) > 0)
                                <div class="row mt-3">
                                    <h4 class="mb-2 header-title text-muted">Product Reviews</h4>
                                    <div class="table-responsive table-bordered ">
                                        <table class="table table-striped mb-0 ">
                                            <tbody>
                                                @foreach($reviews as $val)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <h5>{{$val->name}}</h5>
                                                                <div style="color:darkorange">{{getRatingStar($val->rating)}}</div>
                                                            </div>
                                                            <div class="mt-1">{{$val->reviews}}</div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.includes.footer')
        </div>
    @endsection
