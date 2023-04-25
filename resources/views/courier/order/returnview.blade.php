@extends('courier.layout')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3>{{ $page_title }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="table-responsive table-bordered ">
                                            <table class="table table-striped mb-0 ">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row" width="200">Order Date</th>
                                                        <td>{{ $row->order->created_at }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Order ID</th>
                                                        <td>{{ $row->order->order_id }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Customer Name</th>
                                                        <td>{{ $row->user->first_name }} {{ $row->user->last_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Total Items</th>
                                                        <td>{{ $row->order_item->item_count }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Sub Total</th>
                                                        <td>AED {{ $row->order_item->sub_total }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Grand Total</th>
                                                        <td>AED {{ $row->order_item->item_count * $row->order_item->sub_total }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Payment Transaction ID</th>
                                                        <td> {{ $row->order->payment_transaction_id }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="mb-2 header-title text-muted">Delivery Information</h4>
                                        <div class="table-responsive table-bordered ">
                                            <table class="table table-striped mb-0 ">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row" width="200">Delivery Name</th>
                                                        <td> {{ $row->order->delivery_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Delivery Address</th>
                                                        <td> {{ $row->order->delivery_address }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Delivery City</th>
                                                        <td> {{ $row->order->delivery_city }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Delivery Country</th>
                                                        <td> {{ $row->order->delivery_country }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Delivery Phone</th>
                                                        <td> {{ $row->order->delivery_phone }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <h4 class="mb-2 header-title text-muted">Order Items</h4>
                                    <div class="table-responsive table-bordered ">
                                        <table class="table table-striped mb-0 ">
                                            <thead>
                                                <tr>
                                                    <th width="120">Image</th>
                                                    <th>Product</th>
                                                    <th style="text-align: center" width="150">Item</th>
                                                    <th width="150">Sub Total</th>
                                                    <th width="150">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    <tr>
                                                        <td>
                                                            <div style="width:120px; padding:10px; background-color: #fff; border-radius: 10px;">
                                                                <img src="{{ asset('/storage/product/'.$row->product->main_image)}}" width="100">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            {{$row->product->title}}
                                                        </td>
                                                        <td style="text-align: center"> {{ $row->order_item->item_count }}</td>
                                                        <td> AED {{ $row->order_item->sub_total }}</td>
                                                        <td> {{ getItemStatus($row->order_id, $row->order_item_id) }}</td>
                                                    </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <label>Reason / Message</label>
                                    <div class="mt-2">
                                        {{ $row->reason }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('courier.includes.footer')
        </div>
    @endsection
    @section('footer-scripts')
        @include('courier.make.js.add')
    @endsection
