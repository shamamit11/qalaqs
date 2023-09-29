@extends('admin.layout')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3>Inquiry Details</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="table-responsive table-bordered ">
                                            <table class="table table-striped mb-0 ">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row" width="200">Date</th>
                                                        <td>{{ $row->created_at }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Product</th>
                                                        <td>{{ $row->product->title }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Category</th>
                                                        <td>{{ $row->product->category->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Subcategory</th>
                                                        <td>{{ $row->product->subcategory->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Make</th>
                                                        <td>{{ $row->product->make->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Model</th>
                                                        <td>{{ $row->product->model->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Year</th>
                                                        <td>{{ $row->product->year->name }}</td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <th scope="row" width="200">Vendor Name</th>
                                                        <td>{{ $row->product->vendor->business_name }}</td>
                                                    </tr>

                                                    <tr>
                                                        <th scope="row" width="200">Vendor Phone</th>
                                                        <td>{{ $row->product->vendor->mobile }}</td>
                                                    </tr>

                                                    <tr>
                                                        <th scope="row" width="200">Vendor Address</th>
                                                        <td>{{ $row->product->vendor->address }}, {{ $row->product->vendor->city }}</td>
                                                    </tr>

                                                    <tr>
                                                        <th scope="row" width="200">Customer Name</th>
                                                        <td>{{ $row->user->first_name }} {{ $row->user->last_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Mobile</th>
                                                        <td>{{ $row->user->mobile }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Email Address</th>
                                                        <td>{{ $row->user->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Address</th>
                                                        <td>{{ $row->user->address->address }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">City</th>
                                                        <td>{{ $row->user->address->city }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Country</th>
                                                        <td>{{ $row->user->address->country }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ $row->product->subcategory->icon }}" width="450" style="border-radius: 4px; border: 1px solid #eee">
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
        @include('admin.productinquiry.js.view')
    @endsection
