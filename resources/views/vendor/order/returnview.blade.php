@extends('vendor.layout')
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
                                    <div class="col-md-4">
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
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="table-responsive table-bordered ">
                                            <table class="table table-striped mb-0 ">
                                                <thead>
                                                    <tr>
                                                        <th width="120">Image</th>
                                                        <th>Product</th>
                                                        <th style="text-align: center" width="150">Item</th>
                                                        <th width="150">Sub Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                        <tr>
                                                            <td>
                                                                @php
                                                                    $productImage = getProductImage($row->product->subcategory_id);
                                                                @endphp
                                                                <div style="width:120px; padding:10px; background-color: #fff; border-radius: 10px;">
                                                                    <img src="{{ $productImage }}" width="100">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                {{$row->product->title}}
                                                            </td>
                                                            <td style="text-align: center"> {{ $row->order_item->item_count }}</td>
                                                            <td> AED {{ $row->order_item->sub_total }}</td>
                                                        </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="mt-3">
                                            <label class="text-danger">Reason / Message</label>
                                            <div class="mt-2">
                                                {{ $row->reason }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                

                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('vendor.includes.footer')
        </div>
    @endsection
