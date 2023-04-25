@extends('admin.layout')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3>{{$page_title}}</h3>
                                <nav class="navbar navbar-light">
                                    <form method="get" class="d-flex">
                                        <div class="input-group"> @csrf
                                            <input type="text" name="q" value="{{ @$q }}"
                                                class="form-control" placeholder="Search">
                                            <button class="btn btn-success my-2 my-sm-0" type="submit"><i
                                                    class="align-middle" data-feather="search"></i></button>
                                        </div>
                                    </form>
                                    <a href="{{ route('admin-courier-add') }}" class="btn btn-primary my-2 my-sm-0 ms-1">
                                        Add</a>
                                </nav>
                            </div>
                            <div class="card-body">
                                @if ($couriers->count() > 0)
                                    <table class="table">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="50">#</th>
                                                <th>Business Name</th>
                                                <th>Contact Person</th>
                                                <th>Address</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th style="text-align:center" width="200">Status</th>
                                                <th style="text-align:center" width="120">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($couriers as $courier)
                                                <tr id="tr{{ $courier->id }}">
                                                    <td>{{ $count++ }}</td>
                                                    <td>{{ $courier->business_name }}</td>
                                                    <td>{{ $courier->first_name }} {{ $courier->last_name }}</td>
                                                    <td>{{ $courier->address }}</td>
                                                    <td>{{ $courier->email }}</td>
                                                    <td>{{ $courier->mobile }}</td>
                                                    <td><label class="switch" style="margin: 0 auto">
                                                            <input class="switch-input switch-status"
                                                                type="checkbox" data-id="{{ $courier->id }}"
                                                                data-status-value="{{ $courier->status }}"
                                                                @if ($courier->status == 1) checked @endif />
                                                            <span class="switch-label" data-on="Approved"
                                                                data-off="Pending"></span> <span
                                                                class="switch-handle"></span> </label></td>
                                                    <td style="text-align:center">
                                                        <a href="{{ route('admin-courier-view', ['id=' . $courier->id]) }}"
                                                            class="btn btn-sm btn-warning rounded-pill"
                                                            data-id="{{ $courier->id }}"><span class="icon"><i
                                                                    class='fas fa-eye'></i></span></a>

                                                        <button type="button"
                                                            class="btn btn-sm btn-danger rounded-pill delete-row-btn"
                                                            data-id="{{ $courier->id }}"><span class="icon"><i
                                                                    class='fas fa-trash'></i></span></button>
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
                                            <div class="float-end"> {{ $couriers->links('pagination::bootstrap-4') }}
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
        @include('admin.couriers.js.index')
    @endsection
