@extends('admin.layout')
@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3>My Account</h3>
                                <nav class="navbar navbar-light">
                                  
                                    <a href="{{route('admin-account-change-password')}}"
                                        class="btn btn-primary my-2 my-sm-0 ms-1">
                                        Change Password</a>
                                </nav>
                            </div>
                            <div class="card-body">
                            <form id="form" method="post" action="{{ route('admin-account-addaction') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input class="form-control" name="name" value="{{ old('name', isset($user->name) ? $user->name : '') }}" type="text">
                                    <div class="error" id='error_name'></div>
                                </div>
                                <div class="mb-3 d-grid text-center">
                                    <button class="btn btn-primary btn-loading" type="submit"> Save</button>
                                </div>
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
@include('admin.account.js.index')
@endsection