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
                                        <label class="form-label">Make Name</label>
                                        <select name="make_id" class="select2 form-control">
                                            @if ($makes->count() > 0)
                                            @foreach ($makes as $make)
                                            <option value="{{ $make->id }}" @if (@$row->product_make_id ==
                                                $make->id) selected @endif>{{ $make->name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        <div class="error" id='error_make_id'></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"> Model Name</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{old('name' , isset($row->name)? $row->name : '' )}}">
                                        <div class="error" id='error_name'></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <label class="switch">
                                            <input type="checkbox" class="switch-input" name="status" value="1" {{ ((isset($row->
                status) && $row->status == 1) ||  !isset($row->status))? 'checked' : '' }} /> <span
                                                class="switch-label" data-on="Show" data-off="Hide"></span>
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
    <script src="{{ asset('assets/admin/js/model/add.js') }}"></script>
    @endsection