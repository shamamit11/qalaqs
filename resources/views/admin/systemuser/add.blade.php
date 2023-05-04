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
                                            <label class="form-label">User Type</label>
                                            <select name="user_type" class="form-control" id="user_type">
                                                <option value="S"
                                                    @if (@$row->user_type == 'S') selected @endif>
                                                    Super Admin
                                                </option>
                                                <option value="A"
                                                    @if (@$row->user_type == 'A') selected @endif>
                                                    Standard Admin
                                                </option>
                                            </select>
                                            <div class="error" id='error_user_type'></div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label"> Email Address</label>
                                            <input type="text" class="form-control" name="email" id="email"
                                                value="{{ old('email', isset($row->email) ? $row->email : '') }}">
                                            <div class="error" id='error_email'></div>
                                        </div>

                                        @if(@$row->id < 1 || @$row->id == '')
                                            <div class="mb-3">
                                                <label class="form-label"> User Name</label>
                                                <input type="text" class="form-control" name="username" id="username"
                                                    value="{{ old('username', isset($row->username) ? $row->username : '') }}">
                                                <div class="error" id='error_username'></div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label"> Password</label>
                                                <input type="text" class="form-control" name="password" id="password"
                                                    value="{{ old('password', isset($row->password) ? $row->password : '') }}">
                                                <div class="error" id='error_password'></div>
                                            </div>
                                        @endif

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
        @include('admin.systemuser.js.add')
    @endsection
