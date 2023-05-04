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
                                                        <th scope="row" width="200">Vendor Code</th>
                                                        <td>{{ isset($row->vendor_code) ? $row->vendor_code : '' }}</td>
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
                                                        <th scope="row">Email</th>
                                                        <td>{{ isset($row->email) ? $row->email : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Account Type</th>
                                                        <td>
                                                            @if($row->account_type == 'Seller') Seller @endif
                                                            @if($row->account_type == 'Garage') Garage @endif
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
                                    <div class="col-md-6">
                                        <h4 class="mb-2 header-title text-muted">Vendor Images</h4>
                                        <div class="table-responsive table-bordered ">
                                            <table class="table table-striped mb-0 ">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div
                                                                style="width:270px; padding:10px; background-color: #fff; border-radius: 10px;">
                                                                <div>
                                                                    <img src="{{ asset('/storage/vendor/' . $row->license_image) }}"
                                                                        width="250">
                                                                </div>
                                                                <div class="mt-3 text-center">License</div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div
                                                                style="width:270px; padding:10px; background-color: #fff; border-radius: 10px;">
                                                                <div>
                                                                    <img src="{{ asset('/storage/vendor/' . $row->image) }}"
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

                                @if (count($reviews) > 0)
                                    <div class="row mt-3">
                                        <h4 class="mb-2 header-title text-muted">Reviews</h4>
                                        <div class="table-responsive table-bordered ">
                                            <table class="table table-striped mb-0 ">
                                                <tbody>
                                                    @foreach ($reviews as $val)
                                                        <tr>
                                                            <td>
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center">
                                                                    <h5>{{ $val->user->first_name }} {{ $val->user->last_name }}</h5>
                                                                    <div style="color:darkorange">
                                                                        {{ getRatingStar($val->rating) }}</div>
                                                                </div>
                                                                <div class="mt-1">{{ $val->reviews }}</div>
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
    @section('footer-scripts')
        @include('admin.make.js.add')
    @endsection
