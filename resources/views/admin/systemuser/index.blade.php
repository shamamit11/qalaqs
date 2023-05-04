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
                                <nav class="navbar navbar-light">
                                    <form method="get" class="d-flex">
                                        <div class="input-group"> @csrf
                                            <input type="text" name="q" value="{{ @$q }}"
                                                class="form-control" placeholder="Search">
                                            <button class="btn btn-success my-2 my-sm-0" type="submit"><i
                                                    class="align-middle" data-feather="search"></i></button>
                                        </div>
                                    </form>
                                    <a href="{{ route('admin-systemuser-add') }}" class="btn btn-primary my-2 my-sm-0 ms-1">
                                        Add</a>
                                </nav>
                            </div>
                            <div class="card-body">
                                @if ($system_users->count() > 0)
                                    <table class="table">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="50">#</th>
                                                <th width="220">Name</th>
                                                <th width="180">Username</th>
                                                <th width="">Email</th>
                                                <th style="text-align:center" width="100">User Type</th>
                                                <th style="text-align:center" width="200">Status</th>
                                                <th style="text-align:center" width="120">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($system_users as $systemuser)
                                                <tr id="tr{{ $systemuser->id }}">
                                                    <td>{{ $count++ }}</td>
                                                    <td>{{ $systemuser->name }}</td>
                                                    <td>{{ $systemuser->username }}</td>
                                                    <td>{{ $systemuser->email }}</td>
                                                    <td style="text-align:center">{{ $systemuser->user_type }}</td>
                                                    <td><label class="switch" style="margin: 0 auto">
                                                            <input class="switch-input switch-status" type="checkbox"
                                                                data-id="{{ $systemuser->id }}"
                                                                data-status-value="{{ $systemuser->status }}"
                                                                @if ($systemuser->status == 1) checked @endif /> <span
                                                                class="switch-label" data-on="Show" data-off="Hide"></span>
                                                            <span class="switch-handle"></span> </label></td>
                                                    <td style="text-align:center"><a
                                                            href="{{ route('admin-systemuser-add', ['id=' . $systemuser->id]) }}"
                                                            class="btn btn-sm btn-warning rounded-pill"><i
                                                                class="fas fa-pen"></i></a>
                                                        <button type="button"
                                                            class="btn btn-sm btn-danger rounded-pill delete-row-btn"
                                                            data-id="{{ $systemuser->id }}"><span class="icon"><i
                                                                    class='fas fa-trash'></i></span></button>
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
                                            <div class="float-end"> {{ $system_users->links('pagination::bootstrap-4') }}
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
        @include('admin.systemuser.js.index')
    @endsection
