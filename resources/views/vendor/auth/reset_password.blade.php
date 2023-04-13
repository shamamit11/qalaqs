@include('vendor.includes.metahead')

<body class="loading authentication-bg authentication-bg-pattern">

    <div class="account-pages my-5">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="text-center">
                        <img src="{{ asset('assets/admin/images/aera-logo.png')}}" alt="" height="150" class="mx-auto">
                    </div>
                    <div class="card mt-2">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <h4 class="text-uppercase mt-0">Reset password</h4>
                            </div>
                            <div id='reset_error' class="alert alert-danger alert-dismissible fade show d-none"
                                role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>Invalid token!
                            </div>
                            <form id="frm_reset" method="post" action="{{ route('vendor-save-password') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <input type="password" class="form-control" name="new_password"
                                        value="{{old('new_password')}}" id="new_password">
                                    <div class="error" id='error_new_password'></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        value="{{old('password_confirmation')}}" id="password_confirmation">
                                    <div class="error" id='error_password_confirmation'></div>
                                </div>
                                <div class="mb-3 d-grid text-center">
                                    <button class="btn btn-primary btn-loading" type="submit"> Reset Password </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('vendor.includes.scripts')
    @include('vendor.auth.js.reset')
    </html>
