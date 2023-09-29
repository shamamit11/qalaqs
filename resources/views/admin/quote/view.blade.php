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
                                                        <th scope="row" width="200">Date</th>
                                                        <td>{{ $row->created_at }}</td>
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
                                                        <th scope="row" width="200">Engine</th>
                                                        <td>{{ $row->engine }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">VIN</th>
                                                        <td><img src="{{ asset('/storage/quotes/' . $row->vin) }}"
                                                                width="350"></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Customer Name</th>
                                                        <td>{{ $row->user->first_name }} {{ $row->user->last_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Mobile</th>
                                                        <td>{{ $row->user->mobile }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Email Address</th>
                                                        <td>{{ $row->user->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Address</th>
                                                        <td>{{ $row->user->address->address }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">City</th>
                                                        <td>{{ $row->user->address->city }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Country</th>
                                                        <td>{{ $row->user->address->country }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" width="200">Quotation Status</th>
                                                        <td>{{ $row->status }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <form enctype="multipart/form-data" method="post" action="{{route('admin-quote-update')}}" id="form">
                                            @csrf
                                            <input type="hidden" name="id" value={{$row->id}}>
                                            <div class="mt-3 mb-3">
                                            <label class="form-label">Update Status</label>
                                            <select name="status" class="select form-control" required>
                                                <option value="">Select</option>
                                                <option value="On Process" @if(@$row->status == "On Process") selected @endif>On Process</option>
                                                <option value="Quotation Sent" @if(@$row->status == "Quotation Sent") selected @endif>Quotation Sent</option>
                                                <option value="Shipping" @if(@$row->status == "Shipping") selected @endif>Shipping</option>
                                                <option value="Completed" @if(@$row->status == "Completed") selected @endif>Completed</option>
                                            </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-loading">Submit</button>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="">Image</th>
                                                    <th width="220">Part Name</th>
                                                    <th width="120">Part#</th>
                                                    <th width="50">Qty</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($items as $item)
                                                    <tr>
                                                        <td><img src="{{ asset('/storage/quotes/' . $item->part_image) }}"
                                                            width="240"></td>
                                                        <td>{{ $item->part_name }}</td>
                                                        <td>{{ @$item->part_number }}</td>
                                                        <td>{{ $item->qty }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
        @include('admin.quote.js.view')
    @endsection
