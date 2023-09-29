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
                                <form enctype="multipart/form-data" method="post" action="{{ $action }}" id="form">
                                    @csrf
                                    <input type="hidden" class="form-control" name="id"
                                        value="{{ isset($row->id) ? $row->id : 0 }}">
                                    <div class="mb-3">
                                        <label class="form-label"> Title</label>
                                        <input type="text" class="form-control" name="title" id="title"
                                            value="{{ old('title', isset($row->title) ? $row->title : '') }}">
                                        <div class="error" id='error_title'></div>
                                    </div>

                                    <div class="mb-3 row">
                                        <div class="col-md-4">
                                            <label class="form-label"> Phone</label>
                                            <input type="text" class="form-control" name="phone" id="phone"
                                                value="{{ old('phone', isset($row->phone) ? $row->phone : '') }}">
                                            <div class="error" id='error_phone'></div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"> Description</label>
                                        <textarea class="form-control" name="description" id="description" rows="10">{{ old('description', isset($row->description) ? $row->description : '') }}</textarea>
                                        <div class="error" id='error_description'></div>
                                    </div>
                                    
                                    <div class="mb-3 row">
                                        <div class="col-md-6">
                                            <div class="mb-1">
                                                <label class="form-label">Cover Image</label>
                                                <div class="input-group">
                                                    <input type="text" id="image" class="form-control" name="image"
                                                        aria-label="Image" aria-describedby="button-image"
                                                        value="{{ old('image', isset($row->image) ? $row->image : '') }}"
                                                        readonly>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="button"
                                                            id="button-image">Select</button>
                                                    </div>
                                                </div>
                                                <div class="error" id='error_image'></div>
                                            </div>
                                            <div id="image_select">
                                                @php
                                                    $image_link = isset($row->image) ? $row->image : asset('assets/admin/images/browser.png');
                                                @endphp
                                                <img src="{{ $image_link }}" id="image_link" class="image-holder">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-1">
                                                <label class="form-label">Logo</label>
                                                <div class="input-group">
                                                    <input type="text" id="logo" class="form-control" name="logo"
                                                        aria-label="Logo" aria-describedby="button-logo"
                                                        value="{{ old('logo', isset($row->logo) ? $row->logo : '') }}"
                                                        readonly>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="button"
                                                            id="button-logo">Select</button>
                                                    </div>
                                                </div>
                                                <div class="error" id='error_logo'></div>
                                            </div>
                                            <div id="logo_select">
                                                @php
                                                    $logo_link = isset($row->logo) ? $row->logo : asset('assets/admin/images/browser.png');
                                                @endphp
                                                <img src="{{ $logo_link }}" id="logo_link" class="icon-holder">
                                            </div>
                                        </div>
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
            @include('admin.includes.footer')
        </div>
    @endsection
    @section('footer-scripts')
        @include('admin.autoservice.js.add')
    @endsection
