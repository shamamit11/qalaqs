@extends('admin.layout')
@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form enctype="multipart/form-data" method="post" action="{{$action}}" id="form">
                                    @csrf
                                    <input type="hidden" class="form-control" name="id"
                                        value="{{ isset($row->id)? $row->id : '' }}">
                                    <div class="mb-3">
                                        <label class="form-label">Category Name</label>
                                        <select name="category_id" class="select2 form-control">
                                            @if ($categories->count() > 0)
                                            @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @if (@$row->product_category_id ==
                                                $category->id) selected @endif>{{ $category->name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        <div class="error" id='error_category_id'></div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Sub Category Name</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{old('name' , isset($row->name)? $row->name : '' )}}">
                                        <div class="error" id='error_name'></div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <label class="form-label">Order By</label>
                                                <input type="text" class="form-control" name="order"
                                                    value="{{old('order' , isset($row->order) ? $row->order : $order)}}">
                                                <div class="error" id='error_order'></div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <label class="form-label">Status</label>
                                                <label class="switch">
                                                    <input type="checkbox" class="switch-input" name="status" value="1" {{ ((isset($row->
                status) && $row->status == 1) ||  !isset($row->status))? 'checked' : '' }} /> <span
                                                        class="switch-label" data-on="Show" data-off="Hide"></span>
                                                    <span class="switch-handle"></span> </label>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary  btn-loading">Submit</button>
                                </form>
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
    @include('admin.subcategory.js.add')
    @endsection