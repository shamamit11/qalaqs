@extends('admin.layout')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3>Vendor's Report</h3>
                                <nav class="navbar navbar-light">
                                    <form method="get" class="d-flex">
                                        <div class="input-group"> @csrf
                                            <input type="text" name="q" value="{{ @$q }}"
                                                class="form-control" placeholder="Search">
                                            <button class="btn btn-success my-2 my-sm-0" type="submit"><i
                                                    class="align-middle" data-feather="search"></i></button>
                                        </div>
                                    </form>

                                </nav>
                            </div>
                            <div class="card-body">
                                @if ($reports->count() > 0)
                                    <table class="table">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="50">#</th>
                                                <th width="400">Vendors</th>
                                                <th width="250" class="text-center">Total Products</th>
                                                <th>Deals With</th>
                                                <th width="180">Registered Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($reports as $report)
                                                @php
                                                    $makes = ' --- ';
                                                    $make_data = [];
                                                    $total_products = count($report->products);
                                                @endphp
                                                @if (count($report->makes) > 0)
                                                    @foreach ($report->makes as $make)
                                                        @php array_push($make_data, $make->name); @endphp
                                                    @endforeach
                                                    @php $makes = implode(', ', array_unique($make_data)); @endphp
                                                @endif
                                                <tr id="tr{{ $report->id }}">
                                                    <td>{{ $count++ }}</td>
                                                    <td>{{ $report->business_name }}</td>
                                                    <td class="text-center"><strong>{{ $total_products }}</strong></td>
                                                    <td><strong>{{ $makes }}</strong></td>
                                                    <td>{{ $report->created_at }}</td>
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
                                            <div class="float-end"> {{ $reports->links('pagination::bootstrap-4') }} </div>
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
        @include('admin.brand.js.index')
    @endsection
