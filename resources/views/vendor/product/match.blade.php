@extends('vendor.layout')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3>{{ $product->title}} is suitable for: </h3>
                            </div>
                            <div class="card-body">
                                <form enctype="multipart/form-data" method="post" action="{{ $action }}"
                                    id="form">
                                    @csrf
                                    <input type="hidden" class="form-control" name="product_id" id="product_id"
                                        value="{{ isset($product_id) ? $product_id : '' }}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Make</label>
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
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"> Model Name</label>
                                                <select name="model_id" id="model_id" class="select2 form-control">
                                                    @if ($models->count() > 0)
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
                                                                data-chained="{{ $year->model_id }}"
                                                                @if (@$row->year_id == $year->id) selected @endif>
                                                                {{ $year->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <div class="error" id='error_year_id'></div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Engine</label>
                                                <select name="engine_id" id="engine_id" class="select2 form-control">
                                                    @if ($engines->count() > 0)
                                                        @foreach ($engines as $engine)
                                                            <option value="{{ $engine->id }}"
                                                                data-chained="{{ $engine->year_id }}"
                                                                @if (@$row->engine_id == $engine->id) selected @endif>
                                                                {{ $engine->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <div class="error" id='error_engine_id'></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="">
                                        <button type="submit" class="btn btn-primary btn-loading">Submit</button>
                                        <a href="{{ route('vendor-product-add', ['id=' . $product_id]) }}" class="btn btn-danger">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('vendor.includes.footer')
        </div>
    @endsection
    @section('footer-scripts')
        @include('vendor.product.js.match')
    @endsection
