@extends('courier.layout')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Update Your Password</h4>
                                <p class="sub-header">
                                    Updating your password regularly is an essential security practice that helps protect sensitive information from unauthorized access.
                                </p>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <form id="form" method="post"
                                            action="{{ route('courier-account-update-password') }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label">Old Password</label>
                                                <input class="form-control" name="old_password" type="password"
                                                    id="old_password">
                                                <div class="error" id='error_old_password'></div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">New Password</label>
                                                <input class="form-control" name="new_password" type="password"
                                                    id="new_password">
                                                <div class="error" id='error_new_password'></div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Confirm Password</label>
                                                <input class="form-control" name="confirm_password" type="password"
                                                    id="confirm_password">
                                                <div class="error" id='error_confirm_password'></div>
                                            </div>

                                            <div class="col-5 mb-3 d-grid text-center">
                                                <button class="btn btn-primary btn-loading" type="submit"> Change
                                                    Password</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            @include('courier.includes.footer')
        </div>
    @endsection
    @section('footer-scripts')
        @include('courier.account.js.change_password')
    @endsection
