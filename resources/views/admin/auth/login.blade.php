@include('admin.includes.metahead')

<body class="loading authentication-bg authentication-bg-pattern">

    <div class="account-pages my-5">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="text-center">
                        <img src="{{ asset('assets/admin/images/qalaqs-logo.png')}}" alt="" height="60" class="mx-auto">
                    </div>
                    <div class="card mt-3">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <h4 class="text-uppercase mt-0">Sign In</h4>
                            </div>
                            <div id='login_error' class="alert alert-danger alert-dismissible fade show d-none"
                                role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                                Username or Password Not Matched!
                            </div>
                            <form id="frm_login" method="post" action="{{ route('admin-checkLogin') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Email / Username</label>
                                    <input class="form-control" name="email" type="text" placeholder="Enter your email / username" id='email'>
                                    <div class="error" id='error_email'></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" name="password" class="form-control"
                                            placeholder="Enter your password" id='password'>
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                    <div class="error" id='error_password'></div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="remember_me" class="form-check-input" checked>
                                        <label class="form-check-label">Remember me</label>
                                    </div>
                                </div>
                                <div class="mb-3 d-grid text-center">
                                    <button class="btn btn-primary btn-loading" type="submit"> Log In </button>
                                </div>
                            </form>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <p> <a href="{{route('admin-forgot-password')}}" class="text-muted ms-1"><i
                                            class="fa fa-lock me-1"></i>Forgot your password?</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.includes.scripts')
    @include('admin.auth.js.login')
    </html>