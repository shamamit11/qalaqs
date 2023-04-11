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
                            </div>
                            <div class="card-body">
                                <div class="col-6">
                                    <form enctype="multipart/form-data" method="post" action="{{ $action }}" id="form">
                                        @csrf
                                        <input type="hidden" class="form-control" name="id"
                                            value="{{ isset($row->id) ? $row->id : '' }}">
                                        <div class="mb-3">
                                            <label class="form-label">Category Name</label>
                                            <select name="category_id" class="select2 form-control" id="category_id">
                                                @if ($categories->count() > 0)
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            @if (@$row->product_category_id == $category->id) selected @endif>
                                                            {{ $category->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <div class="error" id='error_category_id'></div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Sub Category Name</label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                value="{{ old('name', isset($row->name) ? $row->name : '') }}">
                                            <div class="error" id='error_name'></div>
                                        </div>
                                        <div class="mb-3 col-3">
                                            <label class="form-label">Order By</label>
                                            <input type="text" class="form-control" name="order" id="order"
                                                value="{{ old('order', isset($row->order) ? $row->order : $order) }}">
                                            <div class="error" id='error_order'></div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <label class="switch">
                                                <input type="checkbox" class="switch-input" name="status" id="status"
                                                    value="1"
                                                    {{ (isset($row->status) && $row->status == 1) || !isset($row->status) ? 'checked' : '' }} />
                                                <span class="switch-label" data-on="Show" data-off="Hide"></span>
                                                <span class="switch-handle"></span> </label>
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
