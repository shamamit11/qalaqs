@extends('vendor.layout')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3>{{ $order->order_id }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="table-responsive table-bordered ">
                                            <table class="table table-striped mb-0 ">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row" width="200">Order Date</th>
                                                        <td>{{ $order->created_at }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Customer Name</th>
                                                        <td>{{ $order->user->first_name }} {{ $order->user->last_name }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Total Items</th>
                                                        <td>{{ $order->item_count }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Item Price</th>
                                                        <td>AED {{ $item->amount }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Sub Total</th>
                                                        <td>AED {{ $item->amount *  $order->item_count}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Discount ({{ $item->product->discount }}%)</th>
                                                        <td>(-) AED {{ ($item->amount *  $order->item_count) * $item->product->discount / 100 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Grand Total</th>
                                                        <td>AED {{ $order->sub_total }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Admin Commission (20%)</th>
                                                        <td>(-) AED {{ $order->sub_total * 20 / 100 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Total Receivable</th>
                                                        <td>AED {{ $order->sub_total - ($order->sub_total * 20 / 100) }}</td>
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
                                                        <th width="150">Unit Price</th>
                                                        <th width="150">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div
                                                                style="width:120px; padding:10px; background-color: #fff; border-radius: 10px;">
                                                                <img src="{{ asset('/storage/product/' . $item->product->main_image) }}"
                                                                    width="100">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            {{ $item->product->title }}
                                                        </td>
                                                        <td style="text-align: center"> {{ $item->item_count }}</td>
                                                        <td> AED {{ $item->amount }}</td>
                                                        <td>
                                                            @php
                                                                $status = getItemStatus($item->order_id, $item->id);
                                                            @endphp
                                                            @if ($status == 'New')
                                                                <span class="badge bg-pink"
                                                                    style="padding:6px; font-size:14px;">New Order</span>
                                                            @endif
                                                            @if ($status == 'Confirmed')
                                                                <span class="badge bg-blue"
                                                                    style="padding:6px; font-size:14px;">Confirmed</span>
                                                            @endif
                                                            @if ($status == 'Ready')
                                                                <span class="badge bg-info"
                                                                    style="padding:6px; font-size:14px;">Ready to Ship</span>
                                                            @endif
                                                            @if ($status == 'Shipped')
                                                                <span class="badge bg-info"
                                                                    style="padding:6px; font-size:14px;">Shipped</span>
                                                            @endif
                                                            @if ($status == 'Completed')
                                                                <span class="badge bg-success"
                                                                    style="padding:6px; font-size:14px;">Completed</span>
                                                            @endif
                                                            @if ($status == 'Cancelled')
                                                                <span class="badge bg-danger"
                                                                    style="padding:6px; font-size:14px;">Cancelled</span>
                                                            @endif
                                                            @if ($status == 'Exchange')
                                                                <span class="badge bg-warning"
                                                                    style="padding:6px; font-size:14px;">Exchange</span>
                                                            @endif
                                                            @if ($status == 'Refund')
                                                                <span class="badge bg-secondary"
                                                                    style="padding:6px; font-size:14px;">Refund</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                               
                                @if($status == 'Processing' || $status == 'Confirmed' || $status == 'Ready')
                                    <hr>
                                    <form enctype="multipart/form-data" method="post" id="form" action={{route('vendor-order-update-status')}}>
                                        @csrf
                                        <input type="hidden" class="form-control" name="order_item_id" value="{{$item->id}}">
                                        <div class="mt-3 col-3">
                                            <label class="form-label text-primary"> Update Order Status</label>
                                            <select name="status_id" id="status_id" class="selectize form-control">
                                                @if($status == 'Confirmed')
                                                    <option value="3">Ready to Ship</option>
                                                    <option value="4">Shipped</option>
                                                @elseif($status == 'Ready')
                                                    <option value="4">Shipped</option>
                                                @else
                                                    <option value="2">Confirmed</option>
                                                    <option value="3">Ready to Ship</option>
                                                    <option value="4">Shipped</option>
                                                @endif
                                            </select>
                                            <div class="error" id='error_status_id'></div>
                                        </div>
                                        <div class="mt-2">
                                            <button type="submit" class="btn btn-primary  btn-loading">Submit</button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('vendor.includes.footer')
        </div>
    @endsection
    @section('footer-scripts')
        @include('vendor.order.js.view')
    @endsection
