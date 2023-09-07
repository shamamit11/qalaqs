@extends('admin.layout')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3>Request Details</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="table-responsive table-bordered ">
                                            <table class="table table-striped mb-0 ">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row" width="200">Order Date</th>
                                                        <td>{{ $row->created_at }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Part Number</th>
                                                        <td>{{ $row->part_number }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Chasis Number</th>
                                                        <td>{{ $row->chasis_number }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Quantity</th>
                                                        <td>{{ $row->qty }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Make</th>
                                                        <td>{{ $row->make->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Model</th>
                                                        <td>{{ $row->model->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Year</th>
                                                        <td>{{ $row->year->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Customer Name</th>
                                                        <td>{{ $row->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Mobile</th>
                                                        <td>{{ $row->mobile }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Email Address</th>
                                                        <td>{{ $row->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Address</th>
                                                        <td>{{ $row->address }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">City</th>
                                                        <td>{{ $row->city }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Country</th>
                                                        <td>{{ $row->country }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset('/storage/specialorders/' . $row->image) }}" width="350">
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
