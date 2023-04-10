@include('admin.includes.metahead')

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
                                <h4 class="text-uppercase mt-0">Reset Password</h4>
                            </div>
                            <form id="frm_forgot" method="post" action="{{ route('admin-forget-password') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Email address</label>
                                    <input class="form-control" name="email" type="text" placeholder="Enter your email" id="email">
                                    <div class="error" id='error_email'></div>
                                </div>
                                <div class="mb-3 d-grid text-center">
                                    <button class="btn btn-primary btn-loading" type="submit"> Reset Password </button>
                                </div>
                            </form>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <p> <a href="{{route('admin-login')}}" class="text-muted ms-1"> Back To Log In</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.includes.scripts')
    @include('admin.auth.js.forgot')
    </html>