@extends('admin.layout')
@section('content')
    <div class="content-page">
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title mt-0 mb-3">Sales Analytics</h4>
                                <div class="widget-box-2">
                                    <div class="widget-detail-2 text-end"> <span
                                            class="badge bg-success rounded-pill float-start mt-3">32% <i
                                                class="mdi mdi-trending-up"></i> </span>
                                        <h2 class="fw-normal mb-1"> 8451 </h2>
                                        <p class="text-muted mb-3">Revenue today</p>
                                    </div>
                                    <div class="progress progress-bar-alt-success progress-sm">
                                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="77"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 77%;"> <span
                                                class="visually-hidden">77% Complete</span> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title mt-0 mb-3">Daily Sales</h4>
                                <div class="widget-box-2">
                                    <div class="widget-detail-2 text-end"> <span
                                            class="badge bg-pink rounded-pill float-start mt-3">32% <i
                                                class="mdi mdi-trending-up"></i> </span>
                                        <h2 class="fw-normal mb-1"> 158 </h2>
                                        <p class="text-muted mb-3">Revenue today</p>
                                    </div>
                                    <div class="progress progress-bar-alt-pink progress-sm">
                                        <div class="progress-bar bg-pink" role="progressbar" aria-valuenow="77"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 77%;"> <span
                                                class="visually-hidden">77% Complete</span> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->

                </div>
            </div>
            <!-- container-fluid -->
        </div>
        <!-- content -->
        @include('admin.includes.footer')

    </div>
@endsection
