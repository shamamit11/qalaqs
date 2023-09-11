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
                            </div>
                            <div class="card-body">
                                @if ($vendors->count() > 0)
                                    <table class="table">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="50">#</th>
                                                <th>Vendors</th>
                                                <th width="400">Address</th>
                                                <th width="150">Mobile</th>
                                                <th width="150">Part Types</th>
                                                <th width="150">Market</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($vendors as $v)
                                                <tr id="tr{{ $v->id }}">
                                                    <td>{{ $count++ }}</td>
                                                    <td>{{ $v->vendor->business_name }}</td>
                                                    <td>{{ $v->vendor->address }}, {{ $v->vendor->city }}</td>
                                                    <td>{{ $v->vendor->mobile }}</td>
                                                    <td>{{ $v->part_type }}</td>
                                                    <td>{{ $v->market }}</td>
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
                                            <div class="float-end"> {{ $vendors->links('pagination::bootstrap-4') }} </div>
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
