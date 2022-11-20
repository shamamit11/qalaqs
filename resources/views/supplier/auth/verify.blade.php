@include('supplier.includes.metahead')

<body class="loading authentication-bg authentication-bg-pattern">

    <div class="account-pages my-5">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="text-center">
                        <img src="{{ asset('assets/supplier/images/logo-dark.png')}}" alt="" height="22" class="mx-auto">
         

                    </div>
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <h4 class="text-uppercase mt-0">Verification</h4>
                            </div>
                            <div id='verify_error' class="alert alert-danger alert-dismissible fade show d-none" role="alert">
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                           Invalid code.
                                        </div>
                            <form id="frm_verify" method="post" action="{{ route('verify-supplier') }}">
                                @csrf
                                <input class="form-control" name="email" type="hidden" value="{{ $email }}" >
                                <div class="mb-3">
                                    <label class="form-label">Verification Code</label>
                                    <input class="form-control" name="verification_code" type="text">
                                    <div class="error" id='error_verification_code'></div>
                                </div>
                                <div class="mb-3 d-grid text-center">
                                    <button class="btn btn-primary btn-loading" type="submit"> Verify </button>
                                </div>
                            </form>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                        <p class="text-muted">Already have account? <a href="{{route('supplier-login')}}"
                                        class="text-dark ms-1"><b>Sign In</b></a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('supplier.includes.scripts')
    <script src="{{ asset('assets/supplier/js/auth/verify.js') }}"></script>
    </html>
