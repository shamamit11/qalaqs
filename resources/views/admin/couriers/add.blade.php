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
                                <form id="form" method="post" action="{{ $action }}">
                                    @csrf
                                    <input type="hidden" class="form-control" name="id"
                                            value="{{ isset($row->id) ? @$row->id : '' }}">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Courier Code</label>
                                                    <input class="form-control"
                                                        value="{{ isset($row->courier_code) ? @$row->courier_code : 'Auto Generated' }}"
                                                        type="text" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Account Type</label>
                                                    <select name="account_type" id="account_type"
                                                        class="selectize form-control">
                                                        <option value="A"
                                                            @if (@$row->account_type == 'A') selected @endif>Admin
                                                        </option>
                                                        <option value="D"
                                                            @if (@$row->account_type == 'D') selected @endif>Driver
                                                        </option>
                                                    </select>
                                                    <div class="error" id='error_account_type'></div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Business Name</label>
                                                <input class="form-control" name="business_name"
                                                    value="{{ old('business_name', isset($row->business_name) ? $row->business_name : '') }}"
                                                    type="text" id="business_name">
                                                <div class="error" id='error_business_name'></div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Contact First Name</label>
                                                    <input class="form-control" name="first_name"
                                                        value="{{ old('first_name', isset($row->first_name) ? $row->first_name : '') }}"
                                                        type="text" id="first_name">
                                                    <div class="error" id='error_first_name'></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Contact Last Name</label>
                                                    <input class="form-control" name="last_name"
                                                        value="{{ old('last_name', isset($row->last_name) ? $row->last_name : '') }}"
                                                        type="text" id="last_name">
                                                    <div class="error" id='error_last_name'></div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Designation</label>
                                                <input class="form-control" name="designation"
                                                    value="{{ old('designation', isset($row->designation) ? $row->designation : '') }}"
                                                    type="text" id="designation">
                                                <div class="error" id='error_designation'></div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Mobile / WhatsApp</label>
                                                    <input class="form-control" name="mobile"
                                                        value="{{ old('mobile', isset($row->mobile) ? $row->mobile : '') }}"
                                                        type="text" id="mobile">
                                                    <div class="error" id='error_mobile'></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Phone Number</label>
                                                    <input class="form-control" name="phone"
                                                        value="{{ old('phone', isset($row->phone) ? $row->phone : '') }}"
                                                        type="text" id="phone">
                                                    <div class="error" id='error_phone'></div>
                                                </div>
                                            </div>
                                           

                                            <div class="mb-3">
                                                <label class="form-label">Address</label>
                                                <input class="form-control" name="address"
                                                    value="{{ old('address', isset($row->address) ? $row->address : '') }}"
                                                    type="text" id="address">
                                                <div class="error" id='error_address'></div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">City</label>
                                                <input class="form-control" name="city"
                                                    value="{{ old('city', isset($row->city) ? $row->city : '') }}"
                                                    type="text" id="city">
                                                <div class="error" id='error_city'></div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input class="form-control" name="email" id="email"
                                                    value="{{ old('email', isset($row->email) ? $row->email : '') }}"
                                                    type="text">
                                                <div class="error" id='error_email'></div>
                                            </div>

                                            @if(@$row->id == 0)
                                                <div class="mb-3">
                                                    <label class="form-label">Password</label>
                                                    <input class="form-control" name="password" id="password"
                                                        value="{{ old('email', isset($row->password) ? $row->password : '') }}"
                                                        type="text">
                                                    <div class="error" id='error_password'></div>
                                                </div>
                                            @endif

                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-4">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="form-label"> Profile Image <small> (150px X
                                                                150px)</small></label>
                                                        <br>
                                                        <input type="file" name="file_image" id="file_image"
                                                            class="d-none" onchange="profileImageBrowser(this)">
                                                        <label type="button" for="file_image"
                                                            class="btn btn-secondary">Choose File</label>
                                                        <input name="image" type="hidden" id="image"
                                                            value="{{ old('image', isset($row->image) ? @$row->image : '') }}" />
                                                        <div>
                                                            @if (@$row && @$row->image)
                                                                <div style="margin:5px 0 0 0;">
                                                                    <img src="{{ asset('/storage/vendor/' . @$row->image) }}"
                                                                        id="displayImg" class="profile-image-preview">
                                                                </div>
                                                            @else
                                                                <div style="margin:5px 0 0 0;">
                                                                    <img src="{{ asset('/assets/admin/images/browser.png') }}"
                                                                        id="displayImg" class="profile-image-preview">
                                                                </div>
                                                            @endif
                                                            <div style="margin:5px 0 0 0;"
                                                                class="{{ @$row && @$row->image ? 'd-block' : 'd-none' }}"
                                                                id='btn_image_delete'>
                                                                <button type="button" class="btn btn-xs btn-danger"
                                                                    Onclick="confirmDelete('image', '{{ @$row->image }}', 'displayImg', 'btn_image_delete')">Remove
                                                                    Image</button>
                                                            </div>
                                                        </div>
                                                        <div class="error" id='error_image'></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="form-label"> License Image</label>
                                                        <br>
                                                        <input type="file" name="file_license_image" id="file_license_image"
                                                            class="d-none" onchange="licenseImageBrowser(this)">
                                                        <label type="button" for="file_license_image"
                                                            class="btn btn-secondary">Choose File</label>
                                                        <input name="license_image" type="hidden" id="license_image"
                                                            value="{{ old('license_image', isset($row->license_image) ? @$row->license_image : '') }}" />
                                                        <div>
                                                            @if (@$row && @$row->license_image)
                                                                <div style="margin:5px 0 0 0;">
                                                                    <img src="{{ asset('/storage/vendor/' . @$row->license_image) }}"
                                                                        id="displayLicenseImg" class="file-image-preview">
                                                                </div>
                                                            @else
                                                                <div style="margin:5px 0 0 0;">
                                                                    <img src="{{ asset('/assets/admin/images/browser.png') }}"
                                                                        id="displayLicenseImg" class="file-image-preview">
                                                                </div>
                                                            @endif
                                                            <div style="margin:5px 0 0 0;"
                                                                class="{{ @$row && @$row->license_image ? 'd-block' : 'd-none' }}"
                                                                id='btn_license_image_delete'>
                                                                <button type="button" class="btn btn-xs btn-danger"
                                                                    Onclick="confirmDelete('license_image', '{{ @$row->license_image }}', 'displayLicenseImg', 'btn_license_image_delete')">Remove
                                                                    Image</button>
                                                            </div>
                                                        </div>
                                                        <div class="error" id='error_license_image'></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-loading" type="submit"> Submit </button>
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
        @include('admin.couriers.js.add')
    @endsection
