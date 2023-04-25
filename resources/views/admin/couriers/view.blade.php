@extends('admin.layout')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3>{{ isset($row->business_name) ? $row->business_name : '' }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="table-responsive table-bordered ">
                                            <table class="table table-striped mb-0 ">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row" width="200">Code</th>
                                                        <td>{{ isset($row->courier_code) ? $row->courier_code : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Business Name</th>
                                                        <td>{{ isset($row->business_name) ? $row->business_name : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Contact Person</th>
                                                        <td>{{ isset($row->first_name) ? $row->first_name . ' ' . $row->last_name : '' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Address</th>
                                                        <td>{{ isset($row->address) ? $row->address : '' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">City</th>
                                                        <td>{{ isset($row->city) ? $row->city : '' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Mobile</th>
                                                        <td>{{ isset($row->mobile) ? $row->mobile : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Phone</th>
                                                        <td>{{ isset($row->mobile) ? $row->phone : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Email</th>
                                                        <td>{{ isset($row->email) ? $row->email : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Account Type</th>
                                                        <td>
                                                            @if($row->account_type == 'A') Admin @endif
                                                            @if($row->account_type == 'D') Driver @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Account Created At</th>
                                                        <td>{{ isset($row->created_at) ? $row->created_at : '' }}</td>
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
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="mb-2 header-title text-muted">Images</h4>
                                        <div class="table-responsive table-bordered ">
                                            <table class="table table-striped mb-0 ">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div
                                                                style="width:270px; padding:10px; background-color: #fff; border-radius: 10px;">
                                                                <div>
                                                                    <img src="{{ asset('/storage/courier/' . $row->license_image) }}"
                                                                        width="250">
                                                                </div>
                                                                <div class="mt-3 text-center">License</div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div
                                                                style="width:270px; padding:10px; background-color: #fff; border-radius: 10px;">
                                                                <div>
                                                                    <img src="{{ asset('/storage/courier/' . $row->image) }}"
                                                                        width="250">
                                                                </div>
                                                                <div class="mt-3 text-center">Profile Image</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
