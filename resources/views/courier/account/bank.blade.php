@extends('courier.layout')
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
                                <form id="form" method="post" action="{{ route('courier-account-bank-addaction') }}">
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
        @include('courier.account.js.bank')
    @endsection
