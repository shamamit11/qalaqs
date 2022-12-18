@extends('supplier.layout')
@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3>Change Password</h3>
                                <nav class="navbar navbar-light">
                                  
                                    <a href="{{route('supplier-account-setting')}}"
                                        class="btn btn-primary my-2 my-sm-0 ms-1">
                                        My account</a>
                                </nav>
                            </div>
                            <div class="card-body">
                            <form id="form" method="post" action="{{ route('supplier-account-update-password') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Old Password</label>
                                    <input class="form-control" name="old_password" type="password">
                                    <div class="error" id='error_old_password'></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <input class="form-control" name="new_password" type="password">
                                    <div class="error" id='error_new_password'></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input class="form-control" name="confirm_password" type="password">
                                    <div class="error" id='error_confirm_password'></div>
                                </div>
                               
                                <div class="mb-3 d-grid text-center">
                                    <button class="btn btn-primary btn-loading" type="submit"> Change Password</button>
                                </div>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @include('supplier.includes.footer')
    </div>
@endsection
@section('footer-scripts')
@include('supplier.account.js.change_password')
@endsection