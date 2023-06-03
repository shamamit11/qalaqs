@extends('vendor.layout')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Bank Information</h4>
                                <p class="sub-header">
                                    Please provide your bank information for financial transaction. We will use the following bank information to transfer your amount.
                                </p>
                                <form id="form" method="post" action="{{ route('vendor-account-bank-addaction') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6">

                                            <div class="mb-3">
                                                <label class="form-label">Bank Name</label>
                                                <input class="form-control" name="bank_name"
                                                    value="{{ old('bank_name', isset($row->bank_name) ? $row->bank_name : '') }}"
                                                    type="text" id="bank_name">
                                                <div class="error" id='error_bank_name'></div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Account Name</label>
                                                    <input class="form-control" name="account_name"
                                                        value="{{ old('account_name', isset($row->account_name) ? $row->account_name : '') }}"
                                                        type="text" id="account_name">
                                                    <div class="error" id='error_account_name'></div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Account Number</label>
                                                <input class="form-control" name="account_no"
                                                    value="{{ old('account_no', isset($row->account_no) ? $row->account_no : '') }}"
                                                    type="text" id="account_no">
                                                <div class="error" id='error_account_no'></div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">IBAN</label>
                                                <input class="form-control" name="iban"
                                                    value="{{ old('iban', isset($row->iban) ? $row->iban : '') }}"
                                                    type="text" id="iban">
                                                <div class="error" id='error_iban'></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="form-label"> Account Image</label>
                                                        <br>
                                                        <input type="file" name="file_image" id="file_image" class="d-none" onchange="bankImageBrowser(this)">
                                                        <label type="button" for="file_image" class="btn btn-secondary">Choose File</label>
                                                        <input name="image" type="hidden" id="image" value="{{ old('image', isset($row->image) ? $row->image : '') }}"/>
                                                        <div>
                                                            @if($row && $row->image)
                                                                <div style="margin:5px 0 0 0;"> 
                                                                    <img src="{{ asset('/storage/vendor/'.$row->image)}}" id="displayImg" class="file-image-preview">
                                                                </div>
                                                            @else
                                                                <div style="margin:5px 0 0 0;"> 
                                                                    <img src="{{ asset('/assets/admin/images/browser.png')}}" id="displayImg" class="file-image-preview">
                                                                </div>
                                                            @endif
                                                            <div style="margin:5px 0 0 0;"
                                                                class="{{ ($row && $row->image) ? 'd-block' : 'd-none' }}"
                                                                id='btn_image_delete'>
                                                                <button type="button" class="btn btn-xs btn-danger"
                                                                    Onclick="confirmDelete('image', '{{$row->image}}', 'displayImg', 'btn_image_delete')">Remove Image</button>
                                                            </div>
                                                        </div>
                                                        <div class="error" id='error_image'></div>
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
            @include('vendor.includes.footer')
        </div>
    @endsection
    @section('footer-scripts')
        @include('vendor.account.js.bank')
    @endsection
