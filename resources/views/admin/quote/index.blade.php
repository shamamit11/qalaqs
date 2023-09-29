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
                                @if ($quotes->count() > 0)
                                    <table class="table">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="50">#</th>
                                                <th width="200">Date</th>
                                                <th width="250">Customer</th>
                                                <th width="150">Mobile#</th>
                                                <th width="">Vehicle</th>
                                                <th width="150">Status</th>
                                                <th style="text-align:center" width="100">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($quotes as $quote)
                                                <tr id="tr{{ $quote->id }}">
                                                    <td>{{ $count++ }}</td>
                                                    <td>{{ $quote->created_at }}</td>
                                                    <td>{{ $quote->user->first_name }} {{ $quote->user->last_name }}</td>
                                                    <td>{{ $quote->user->mobile }}</td>
                                                    <td>{{ $quote->make->name }} / {{ $quote->model->name }} / {{ $quote->year->name }}</td>
                                                    <td>{{ $quote->status }}</td>
                                                    <td style="text-align:center">
                                                        <a href="{{ route('admin-quote-view', ['id=' . $quote->id]) }}"
                                                            class="btn btn-sm btn-warning rounded-pill"
                                                            data-id="{{ $quote->id }}"><span class="icon"><i
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
                                            <div class="float-end"> {{ $quotes->links('pagination::bootstrap-4') }}
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
        @include('admin.quote.js.index')
    @endsection
