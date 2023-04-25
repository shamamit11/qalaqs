@extends('admin.layout')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3>{{ $row->order_id }}</h3>
                                <h3>
                                    <span class="badge bg-primary">Total Amount: {{ $row->grand_total }}</span>
                                </h3>
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
                                                        <th scope="row" width="200">Customer Name</th>
                                                        <td>{{ $row->user->first_name }} {{ $row->user->last_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Total Items</th>
                                                        <td>{{ $row->item_count }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Sub Total</th>
                                                        <td>AED {{ $row->sub_total }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">VAT ({{ $row->vat_percentage }}%)</th>
                                                        <td>AED {{ $row->tax_total }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Delivery Charge</th>
                                                        <td>AED {{ $row->delivery_charge }}</td>
                                                    </tr>
                                                    @if ($row->promo_code)
                                                        <tr>
                                                            <th scope="row">Promo Code</th>
                                                            <td>AED {{ $row->promo_code }}</td>
                                                        </tr>
                                                    @endif
                                                    @if ($row->promo_type)
                                                        <tr>
                                                            <th scope="row">Promo Type</th>
                                                            <td>AED {{ $row->promo_type }}</td>
                                                        </tr>
                                                    @endif
                                                    @if ($row->promo_value)
                                                        <tr>
                                                            <th scope="row">Promo Value</th>
                                                            <td>AED {{ $row->promo_value }}</td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <th scope="row">Grand Total</th>
                                                        <td>AED {{ $row->grand_total }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Payment Transaction ID</th>
                                                        <td> {{ $row->payment_transaction_id }}</td>
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
                                                        <td> {{ $row->delivery_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Delivery Address</th>
                                                        <td> {{ $row->delivery_address }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Delivery City</th>
                                                        <td> {{ $row->delivery_city }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Delivery Country</th>
                                                        <td> {{ $row->delivery_country }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Delivery Phone</th>
                                                        <td> {{ $row->delivery_phone }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @if (count($items) > 0)
                                    <div class="row mt-3">
                                        <h4 class="mb-2 header-title text-muted">Order Items</h4>
                                        <div class="table-responsive table-bordered ">
                                            <table class="table table-striped mb-0 ">
                                                <thead>
                                                    <tr>
                                                        <th width="120">Image</th>
                                                        <th>Product</th>
                                                        <th style="text-align: center" width="150">Item</th>
                                                        <th width="150">Unit Price</th>
                                                        <th width="150">Sub Total</th>
                                                        <th width="150">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($items as $val)
                                                        <tr
                                                            style="background-color: rgb(175, 255, 218); vertical-align: middle">
                                                            <td colspan="6">
                                                                @php
                                                                    $vendor = getVendorDataByProductId($val->product->vendor_id);
                                                                    $order_status = getItemStatus($row->id, $val->id);
                                                                    $order_status_label = getItemStatusLabel($order_status);
                                                                @endphp
                                                                <span> <strong>Vendor:</strong>
                                                                    {{ $vendor->business_name }} </span>
                                                                <span style="margin-left: 20px"> <strong>Pickup
                                                                        Address:</strong> {{ $vendor->address }},
                                                                    {{ $vendor->city }} </span>
                                                                <span style="margin-left: 20px"> <strong>Contact
                                                                        Number:</strong> {{ $vendor->mobile }} </span>

                                                            </td>
                                                        </tr>
                                                        <tr style="vertical-align: middle">
                                                            <td>
                                                                <div
                                                                    style="width:120px; padding:10px; background-color: #fff; border-radius: 10px;">
                                                                    <img src="{{ asset('/storage/product/' . $val->product->main_image) }}"
                                                                        width="100">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                {{ $val->product->title }}
                                                            </td>
                                                            <td style="text-align: center"> {{ $val->item_count }}</td>
                                                            <td> AED {{ $val->amount }}</td>
                                                            <td> AED {{ $val->sub_total }}</td>
                                                            <td style="text-align: center"> {!! $order_status_label !!}</td>
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
