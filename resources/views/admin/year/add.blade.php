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
                                        value="{{ isset($row->id) ? $row->id : '' }}">
                                    <input type="hidden" class="form-control" name="make_id"
                                        value="{{ isset($row->make_id) ? $row->make_id : 1 }}">
                                    <input type="hidden" class="form-control" name="model_id"
                                        value="{{ isset($row->model_id) ? $row->model_id : 1 }}">
                                    {{-- <div class="mb-3">
                                        <label class="form-label">Make Name</label>
                                        <select name="make_id" id="make_id" class="select2 form-control">
                                            @if ($makes->count() > 0)
                                                @foreach ($makes as $make)
                                                    <option value="{{ $make->id }}"
                                                        @if (@$row->make_id == $make->id) selected @endif>
                                                        {{ $make->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <div class="error" id='error_make_id'></div>
                                    </div> --}}
                                    {{-- <div class="mb-3">
                                        <label class="form-label"> Model Name</label>
                                        <select name="model_id" id="model_id" class="select2 form-control">
                                            @if ($models->count() > 0)
                                                @foreach ($models as $model)
                                                    <option value="{{ $model->id }}" class="{{ $model->make_id }}"
                                                        @if (@$row->model_id == $model->id) selected @endif>
                                                        {{ $model->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <div class="error" id='error_model_id'></div>
                                    </div> --}}
                                    <div class="mb-3">
                                        <label class="form-label"> Year</label>
                                        <input type="text" class="form-control" name="name" id="name"
                                            value="{{ old('name', isset($row->name) ? $row->name : '') }}">
                                        <div class="error" id='error_name'></div>
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
        @include('admin.year.js.add')
    @endsection
