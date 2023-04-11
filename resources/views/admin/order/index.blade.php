@extends('admin.layout')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3>{{ $page_title }}</h3>
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
                                @if ($orders->count() > 0)
                                    <table class="table">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="50">#</th>
                                                <th width="200">Date</th>
                                                <th width="200">Order ID</th>
                                                <th width="">Customer</th>
                                                <th style="text-align:center" width="120">Items#</th>
                                                <th width="120">Total (AED)</th>
                                                <th>Trans ID</th>
                                                <th style="text-align:center" width="120">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr id="tr{{ $order->id }}">
                                                    <td>{{ $count++ }}</td>
                                                    <td>{{ $order->created_at }}</td>
                                                    <td>{{ $order->order_id }}</td>
                                                    <td>{{ $order->user->first_name }} {{ $order->user->last_name }}</td>
                                                    <td style="text-align:center">{{ $order->item_count }}</td>
                                                    <td>{{ $order->grand_total }}</td>
                                                    <td>{{ $order->payment_transaction_id }}</td>
                                                    
                                                    <td style="text-align:center">
                                                        <a href="{{ route('admin-order-view', ['id=' . $order->id]) }}"
                                                            class="btn btn-sm btn-warning rounded-pill"
                                                            data-id="{{ $order->id }}"><span class="icon"><i
                                                                    class='fas fa-eye'></i></span></a>

                                                        
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
                                            <div class="float-end"> {{ $orders->links('pagination::bootstrap-4') }}
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
        @include('admin.order.js.index')
    @endsection
