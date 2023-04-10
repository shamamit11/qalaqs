@extends('admin.layout')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                {{-- <h4 class="header-title">Update Your Password</h4>
                                <p class="sub-header">
                                    Updating your password regularly is an essential security practice that helps protect
                                    sensitive information from unauthorized access.
                                </p> --}}
                                <div class="row">
                                    <div class="col-lg-4">
                                        <form id="form" method="post" action="{{ route('admin-account-addaction') }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label">Name</label>
                                                <input class="form-control" name="name"
                                                    value="{{ old('name', isset($user->name) ? $user->name : '') }}"
                                                    type="text" id="name">
                                                <div class="error" id='error_name'></div>
                                            </div>
                                            <div class="col-2 mb-3 d-grid text-center">
                                                <button class="btn btn-primary btn-loading" type="submit"> Save</button>
                                            </div>
                                        </form>
                                    </div>
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
        @include('admin.account.js.index')
    @endsection
