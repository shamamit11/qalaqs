@include('supplier.includes.metahead')

<body class="loading authentication-bg authentication-bg-pattern">

    <div class="account-pages my-5">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="text-center mb-4">
                        <img src="{{ asset('assets/supplier/images/logo-dark.png')}}" alt="" height="22" class="mx-auto">
                    </div>
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <h4 class="text-uppercase mt-0">Register</h4>
                            </div>
                            <div id='register_error' class="alert alert-danger alert-dismissible fade show d-none" role="alert">
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                           Email is already registered.
                                        </div>
                            <form id="frm_register" method="post" action="{{ route('supplier-register') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input class="form-control" name="name" type="text">
                                    <div class="error" id='error_name'></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <input class="form-control" name="address" type="text">
                                    <div class="error" id='error_address'></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">City</label>
                                    <input class="form-control" name="city" type="text">
                                    <div class="error" id='error_city'></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">State</label>
                                    <input class="form-control" name="state" type="text">
                                    <div class="error" id='error_state'></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Zipcode</label>
                                    <input class="form-control" name="zipcode" type="text">
                                    <div class="error" id='error_zipcode'></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Country</label>
                                    <select class="form-control select2" name="country_id">
                                        @foreach($countries as $country)
                                        <option value="{{ $country->id}}">{{ $country->name}}</value>
                                        @endforeach
                                    </select>
                                    <div class="error" id='error_zipcode'></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input class="form-control" name="phone" type="text">
                                    <div class="error" id='error_phone'></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Mobile</label>
                                    <input class="form-control" name="mobile" type="text">
                                    <div class="error" id='error_mobile'></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email address</label>
                                    <input class="form-control" name="email" type="email">
                                    <div class="error" id='error_email'></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input class="form-control" name="password" type="password"
                                        placeholder="Enter your password">
                                    <div class="error" id='error_password'></div>
                                </div>
                                <div class="mb-3 d-grid text-center">
                                    <button class="btn btn-primary btn-loading" type="submit"> Register</button>
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
    <script src="{{ asset('assets/supplier/js/auth/register.js') }}"></script>
    </html>
