@extends('admin.layout')
@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3>Category Management</h3>
                                <nav class="navbar navbar-light">
                                    <form method="get" class="d-flex">
                                        <div class="input-group"> @csrf
                                            <input type="text" name="q" value="{{ @$q }}" class="form-control"
                                                placeholder="Search">
                                            <button class="btn btn-success my-2 my-sm-0" type="submit"><i
                                                    class="align-middle" data-feather="search"></i></button>
                                        </div>
                                    </form>
                                    <a href="{{route('admin-category-add')}}" class="btn btn-primary my-2 my-sm-0 ms-1">
                                        Add</a>
                                </nav>
                            </div>
                            <div class="card-body">
                                @if($categories->count() > 0)
                                <table class="table">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50">#</th>
                                            <th>Name</th>
                                            <th> Orders</th>
                                            <th width="200">Status</th>
                                            <th style="text-align:center" width="120">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($categories as $category)
                                        <tr id="tr{{ $category->id }}">
                                            <td>{{ $count++ }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->order }}</td>
                                            <td><label class="switch" style="margin: 0 auto">
                                                    <input class="switch-input switch-status" type="checkbox"
                                                        data-id="{{ $category->id }}"
                                                        data-status-value="{{ $category->status }}" @if($category->
                                                    status == 1) checked @endif /> <span class="switch-label"
                                                        data-on="Show" data-off="Hide"></span> <span
                                                        class="switch-handle"></span> </label></td>
                                            <td style="text-align:center"><a
                                                    href="{{route('admin-category-add', ['id='.$category->id])}}"
                                                    class="btn btn-sm btn-warning rounded-pill"><i
                                                        class="fas fa-pen"></i></a>
                                                <button type="button"
                                                    class="btn btn-sm btn-danger rounded-pill delete-row-btn"
                                                    data-id="{{ $category->id }}"><span class="icon"><i
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
                                        <div class="float-end"> {{$categories->links('pagination::bootstrap-4')}} </div>
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
        </div>
        @include('admin.includes.footer')
    </div>
    @endsection
    @section('footer-scripts')
    @include('admin.category.js.index')
    @endsection