@extends('admin.layout')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3>Product Management</h3>
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
                                                <th width="300">Vendor</th>
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
                                                    <td>{{ $product->vendor->business_name }}
                                                        ({{ $product->vendor->vendor_code }})</td>
                                                    <td style="text-align:center"><label class="switch"
                                                            style="margin: 0 auto">
                                                            <input class="switch-input switch-status" type="checkbox"
                                                                data-id="{{ $product->id }}"
                                                                data-status-value="{{ $product->admin_approved }}"
                                                                @if ($product->admin_approved == 1) checked @endif /> <span
                                                                class="switch-label" data-on="Approved"
                                                                data-off="Pending"></span> <span
                                                                class="switch-handle"></span> </label></td>
                                                    <td style="text-align:center">
                                                        <a href="{{ route('admin-product-view', ['id=' . $product->id]) }}"
                                                            class="btn btn-sm btn-warning rounded-pill"
                                                            data-id="{{ $product->id }}"><span class="icon"><i
                                                                    class='fas fa-eye'></i></span></a>
                                                        
                                                        @if (checkIfUserIsSuperAdmin())
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger rounded-pill delete-row-btn"
                                                                data-id="{{ $product->id }}"><span class="icon"><i
                                                                        class='fas fa-trash'></i></span></button>
                                                        @endif
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
            @include('admin.includes.footer')
        </div>
    @endsection
    @section('footer-scripts')
        @include('admin.product.js.index')
    @endsection
