@extends('vendor.layout')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3>My Products</h3>
                                <nav class="navbar navbar-light">
                                    <form method="get" class="d-flex">
                                        <div class="input-group">
                                            @csrf
                                            <input type="text" name="q" value="{{ @$q }}"
                                                class="form-control" placeholder="Search" style="width:300px;">
                                            <button class="btn btn-success my-2 my-sm-0" type="submit"><i
                                                    class="align-middle" data-feather="search"></i></button>
                                        </div>
                                    </form>
                                    <a href="{{ route('vendor-product-add') }}" class="btn btn-primary my-2 my-sm-0 ms-1">
                                        Add</a>
                                </nav>
                            </div>
                            <div class="card-body">
                                @if ($products->count() > 0)
                                    <table class="table">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="50">#</th>
                                                <th width="120">SKU</th>
                                                <th width="120">Part#</th>
                                                <th>Title</th>
                                                <th width="100">Stock</th>
                                                <th width="160">Price</th>
                                                <th width="100">Discount</th>
                                                <th style="text-align:center" width="130">Status</th>
                                                <th style="text-align:center" width="150">Admin Approval</th>
                                                <th style="text-align:center" width="120">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($products as $product)
                                                <tr id="tr{{ $product->id }}">
                                                    <td>{{ $count++ }}</td>
                                                    <td>{{ $product->sku }}</td>
                                                    <td>{{ $product->part_number }}</td>
                                                    <td>{{ $product->title }}</td>
                                                    <td>{{ $product->stock }}</td>
                                                    <td>AED {{ $product->price }}</td>
                                                    <td> {{ $product->discount }} %</td>
                                                    <td style="text-align:center">
                                                        @if ($product->status == 1) 
                                                            <span class="badge bg-success" style="padding:6px; font-size:14px;">Active</span>
                                                        @else
                                                            <span class="badge bg-danger" style="padding:6px; font-size:14px;">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td style="text-align:center">
                                                        @if ($product->admin_approved == 1) 
                                                            <span class="badge bg-success" style="padding:6px; font-size:14px;">Approved</span>
                                                        @else
                                                            <span class="badge bg-danger" style="padding:6px; font-size:14px;">Pending</span>
                                                        @endif
                                                    </td>
                                                    <td style="text-align:center">
                                                        <a href="{{ route('vendor-product-view', ['id=' . $product->id]) }}"
                                                            class="btn btn-sm btn-warning rounded-pill"
                                                            data-id="{{ $product->id }}"><span class="icon"><i
                                                                    class='fas fa-eye'></i></span></a>
                                                            <a href="{{ route('vendor-product-add', ['id=' . $product->id]) }}"
                                                                class="btn btn-sm btn-secondary rounded-pill"
                                                                data-id="{{ $product->id }}"><span class="icon"><i
                                                                        class='fas fa-edit'></i></span></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            Showing {{ $from_data }} to {{ $to_data }} of {{ $total_data }}
                                            records.
                                        </div>
                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                            <div class="float-end"> {{ $products->links('pagination::bootstrap-4') }}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-info" role="alert"> No data found. </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('vendor.includes.footer')
        </div>
    @endsection
    @section('footer-scripts')
        @include('vendor.product.js.index')
    @endsection
