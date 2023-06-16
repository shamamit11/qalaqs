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
                                            <label class="form-label"> Category</label>
                                            <select name="category_id" id="category_id"
                                                class="select2 form-control">
                                                @if ($categories->count() > 0)
                                                    <option value="">Select</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            @if (@$row->category_id == $category->id) selected @endif>
                                                            {{ $category->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <div class="error" id='error_category_id'></div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Subcategory</label>
                                            <select name="subcategory_id" id="subcategory_id"
                                                class="select2 form-control">
                                                @if ($subcategories->count() > 0)
                                                    <option value="">Select</option>
                                                    @foreach ($subcategories as $subcategory)
                                                        <option value="{{ $subcategory->id }}"
                                                            data-chained="{{ $subcategory->category_id }}"
                                                            @if (@$row->subcategory_id == $subcategory->id) selected @endif>
                                                            {{ $subcategory->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <div class="error" id='error_subcategory_id'></div>
                                        </div>


                                        <div class="mb-3">
                                            <label class="form-label">Make</label>
                                            <select name="make_id" id="make_id" class="select2 form-control">
                                                @if ($makes->count() > 0)
                                                    <option value="">Select</option>
                                                    @foreach ($makes as $make)
                                                        <option value="{{ $make->id }}"
                                                            @if (@$row->make_id == $make->id) selected @endif>
                                                            {{ $make->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <div class="error" id='error_make_id'></div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Model</label>
                                            <select name="model_id" id="model_id" class="select2 form-control">
                                                @if ($models->count() > 0)
                                                    <option value="">Select</option>
                                                    @foreach ($models as $model)
                                                        <option value="{{ $model->id }}"
                                                            data-chained="{{ $model->make_id }}"
                                                            @if (@$row->model_id == $model->id) selected @endif>
                                                            {{ $model->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <div class="error" id='error_model_id'></div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Year</label>
                                            <select name="year_id" id="year_id" class="select2 form-control">
                                                @if ($years->count() > 0)
                                                    @foreach ($years as $year)
                                                        <option value="{{ $year->id }}"
                                                            @if (@$row->year_id == $year->id) selected @endif>
                                                            {{ $year->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <div class="error" id='error_year_id'></div>
                                        </div>


                                        <div class="mb-3 col-8">
                                            <div class="mb-2">
                                                <label class="form-label">Image</label>
                                                <div class="input-group">
                                                    <input type="text" id="image" class="form-control"
                                                        name="image" aria-label="Image"
                                                        aria-describedby="button-image"
                                                        value="{{ old('image', isset($row->image) ? $row->image : '') }}"
                                                        readonly>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="button"
                                                            id="button-image">Select</button>
                                                    </div>
                                                </div>
                                                <div class="error" id='error_image'></div>
                                            </div>
                                            @php
                                                $image_link = (isset($row->image) ? $row->image : asset('assets/admin/images/browser.png'));
                                            @endphp
                                            <img src="{{ $image_link }}" id="image_link" class="image-holder">
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
        @include('admin.productImage.js.add')
    @endsection
