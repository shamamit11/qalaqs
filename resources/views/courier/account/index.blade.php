@extends('courier.layout')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Profile Information</h4>
                                <p class="sub-header">
                                    Updating your password regularly is an essential security practice that helps protect
                                    sensitive information from unauthorized access.
                                </p>
                                <form id="form" method="post" action="{{ route('courier-account-addaction') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Code</label>
                                                    <input class="form-control" value="{{ $user->courier_code }}" type="text"
                                                        readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Account Type</label>
                                                    <input class="form-control" value="{{ $user->account_type }}" type="text" readonly>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Business Name</label>
                                                <input class="form-control" name="business_name"
                                                    value="{{ old('business_name', isset($user->business_name) ? $user->business_name : '') }}"
                                                    type="text" id="business_name">
                                                <div class="error" id='error_business_name'></div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Contact First Name</label>
                                                    <input class="form-control" name="first_name"
                                                        value="{{ old('first_name', isset($user->first_name) ? $user->first_name : '') }}"
                                                        type="text" id="first_name">
                                                    <div class="error" id='error_first_name'></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Contact Last Name</label>
                                                    <input class="form-control" name="last_name"
                                                        value="{{ old('last_name', isset($user->last_name) ? $user->last_name : '') }}"
                                                        type="text" id="last_name">
                                                    <div class="error" id='error_last_name'></div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Mobile / Whatsapp</label>
                                                <input class="form-control" name="mobile"
                                                    value="{{ old('mobile', isset($user->mobile) ? $user->mobile : '') }}"
                                                    type="text" id="mobile">
                                                <div class="error" id='error_mobile'></div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Phone</label>
                                                <input class="form-control" name="phone"
                                                    value="{{ old('phone', isset($user->phone) ? $user->phone : '') }}"
                                                    type="text" id="phone">
                                                <div class="error" id='error_phone'></div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input class="form-control"
                                                    value="{{ old('email', isset($user->email) ? $user->email : '') }}"
                                                    type="text" readonly>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Address</label>
                                                <input class="form-control" name="address"
                                                    value="{{ old('address', isset($user->address) ? $user->address : '') }}"
                                                    type="text" id="address">
                                                <div class="error" id='error_address'></div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">City</label>
                                                <input class="form-control" name="city"
                                                    value="{{ old('city', isset($user->city) ? $user->city : '') }}"
                                                    type="text" id="city">
                                                <div class="error" id='error_city'></div>
                                            </div>

                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-4">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="form-label"> Profile Image <small> (150px X 150px)</small></label>
                                                        <br>
                                                        <input type="file" name="file_image" id="file_image" class="d-none" onchange="profileImageBrowser(this)">
                                                        <label type="button" for="file_image" class="btn btn-secondary">Choose File</label>
                                                        <input name="image" type="hidden" id="image" value="{{ old('image', isset($user->image) ? $user->image : '') }}"/>
                                                        <div>
                                                            @if($user && $user->image)
                                                                <div style="margin:5px 0 0 0;"> 
                                                                    <img src="{{ asset('/storage/courier/'.$user->image)}}" id="displayImg" class="profile-image-preview">
                                                                </div>
                                                            @else
                                                                <div style="margin:5px 0 0 0;"> 
                                                                    <img src="{{ asset('/assets/admin/images/browser.png')}}" id="displayImg" class="profile-image-preview">
                                                                </div>
                                                            @endif
                                                            <div style="margin:5px 0 0 0;"
                                                                class="{{ ($user && $user->image) ? 'd-block' : 'd-none' }}"
                                                                id='btn_image_delete'>
                                                                <button type="button" class="btn btn-xs btn-danger"
                                                                    Onclick="confirmDelete('image', '{{$user->image}}', 'displayImg', 'btn_image_delete')">Remove Image</button>
                                                            </div>
                                                        </div>
                                                        <div class="error" id='error_image'></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="form-label"> License Image</label>
                                                        <div>
                                                            @if($user && $user->license_image)
                                                                <div style="margin:5px 0 0 0;"> 
                                                                    <img src="{{ asset('/storage/courier/'.$user->license_image)}}" id="displayLicenseImg" class="file-image-preview">
                                                                </div>
                                                            @else
                                                                <div style="margin:5px 0 0 0;"> 
                                                                    <img src="{{ asset('/assets/admin/images/browser.png')}}" id="displayLicenseImg" class="file-image-preview">
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-loading" type="submit"> Update Information</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('courier.includes.footer')
        </div>
    @endsection
    @section('footer-scripts')
        @include('courier.account.js.index')
    @endsection
