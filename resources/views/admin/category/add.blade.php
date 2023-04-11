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
                                    <form enctype="multipart/form-data" method="post" action="{{ $action }}"
                                        id="form">
                                        @csrf
                                        <input type="hidden" class="form-control" name="id"
                                            value="{{ isset($row->id) ? $row->id : '' }}">

                                        <div class="mb-3">
                                            <label class="form-label"> Name</label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                value="{{ old('name', isset($row->name) ? $row->name : '') }}">
                                            <div class="error" id='error_name'></div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Category Type</label>
                                            <select name="type" class="form-control" id="type">
                                                <option value="default"
                                                    @if (@$row->type == 'default') selected @endif>
                                                    Default
                                                </option>
                                                <option value="other"
                                                    @if (@$row->type == 'other') selected @endif>
                                                    Others
                                                </option>
                                            </select>
                                            <div class="error" id='error_type'></div>
                                        </div>

                                        <div class="mb-3 col-8">
                                            <div class="mb-2">
                                                <label class="form-label">Icon</label>
                                                <div class="input-group">
                                                    <input type="text" id="icon" class="form-control"
                                                        name="icon" aria-label="Icon"
                                                        aria-describedby="button-icon"
                                                        value="{{ old('icon', isset($row->icon) ? $row->icon : '') }}"
                                                        readonly>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="button"
                                                            id="button-icon">Select</button>
                                                    </div>
                                                </div>
                                                <div class="error" id='error_icon'></div>
                                            </div>
                                            @php
                                                $icon_link = (isset($row->icon) ? $row->icon : asset('assets/admin/images/icon.png'));
                                            @endphp
                                            <img src="{{ $icon_link }}" id="icon_link" class="icon-holder">
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
                                                <input type="checkbox" class="switch-input" name="status" value="1"
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
        @include('admin.category.js.add')
    @endsection
