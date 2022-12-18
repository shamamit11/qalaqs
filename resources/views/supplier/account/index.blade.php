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
                                <h3>My Account</h3>
                                <nav class="navbar navbar-light">
                                  
                                    <a href="{{route('supplier-account-change-password')}}"
                                        class="btn btn-primary my-2 my-sm-0 ms-1">
                                        Change Password</a>
                                </nav>
                            </div>
                            <div class="card-body">
                            <form id="form" method="post" action="{{ route('supplier-account-addaction') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input class="form-control" name="name" value="{{ old('name', isset($user->name) ? $user->name : '') }}" type="text">
                                    <div class="error" id='error_name'></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <input class="form-control" name="address" value="{{ old('address', isset($user->address) ? $user->address : '') }}" type="text">
                                    <div class="error" id='error_address'></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">City</label>
                                    <input class="form-control" name="city" value="{{ old('city', isset($user->city) ? $user->city : '') }}" type="text">
                                    <div class="error" id='error_city'></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">State</label>
                                    <input class="form-control" name="state" value="{{ old('state', isset($user->state) ? $user->state : '') }}" type="text">
                                    <div class="error" id='error_state'></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Zipcode</label>
                                    <input class="form-control" name="zipcode" value="{{ old('zipcode', isset($user->zipcode) ? $user->zipcode : '') }}" type="text">
                                    <div class="error" id='error_zipcode'></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Country</label>
                                    <select class="form-control select2" name="country_id">
                                        @foreach($countries as $country)
                                        <option value="{{ $country->id}}" @if($user->country_id == $country->id) selected @endif>{{ $country->name}}</value>
                                            @endforeach
                                    </select>
                                    <div class="error" id='error_zipcode'></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input class="form-control" name="phone" value="{{ old('phone', isset($user->phone) ? $user->phone : '') }}" type="text">
                                    <div class="error" id='error_phone'></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Mobile</label>
                                    <input class="form-control" name="mobile" value="{{ old('mobile', isset($user->mobile) ? $user->mobile : '') }}" type="text">
                                    <div class="error" id='error_mobile'></div>
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
        @include('supplier.includes.footer')
    </div>
@endsection
@section('footer-scripts')
@include('supplier.account.js.index')
@endsection