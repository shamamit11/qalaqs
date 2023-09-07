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
                                @if ($specialrequests->count() > 0)
                                    <table class="table">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="50">#</th>
                                                <th width="200">Date</th>
                                                <th width="250">Customer</th>
                                                <th width="150">Part#</th>
                                                <th width="150">Chasis#</th>
                                                <th width="">Vehicle</th>
                                                <th style="text-align:center" width="100">Qty</th>
                                                <th style="text-align:center" width="100">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($specialrequests as $specialrequest)
                                                <tr id="tr{{ $specialrequest->id }}">
                                                    <td>{{ $count++ }}</td>
                                                    <td>{{ $specialrequest->created_at }}</td>
                                                    <td>{{ $specialrequest->name }}</td>
                                                    <td>{{ $specialrequest->part_number }}</td>
                                                    <td>{{ $specialrequest->chasis_number }}</td>
                                                    <td>{{ $specialrequest->make->name }} / {{ $specialrequest->model->name }} / {{ $specialrequest->year->name }}</td>
                                                    <td style="text-align:center">{{ $specialrequest->qty }}</td>
                                                    
                                                    <td style="text-align:center">
                                                        <a href="{{ route('admin-specialrequest-view', ['id=' . $specialrequest->id]) }}"
                                                            class="btn btn-sm btn-warning rounded-pill"
                                                            data-id="{{ $specialrequest->id }}"><span class="icon"><i
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
                                            <div class="float-end"> {{ $specialrequests->links('pagination::bootstrap-4') }}
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
        @include('admin.specialrequest.js.index')
    @endsection
