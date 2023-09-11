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

                                <h4 class="header-title mt-0 mb-3">Special Requests</h4>

                                <div class="widget-box-2">
                                    <div class="widget-detail-2 text-start float-start">
                                        <h2 class="fw-normal mb-1"> {{ $today_special_requests }} </h2>
                                        <p class="text-muted mb-3">Today's Requests</p>
                                    </div>
                                    <div class="widget-detail-2 text-end float-end">
                                        <h2 class="fw-normal mb-1"> {{ $total_special_requests }} </h2>
                                        <p class="text-muted mb-3">Total Requests</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="header-title mt-0 mb-3">Sales / Orders</h4>

                                <div class="widget-box-2">
                                    <div class="widget-detail-2 text-start float-start">
                                        <h2 class="fw-normal mb-1"> {{ $today_orders }} </h2>
                                        <p class="text-muted mb-3">Today's Orders</p>
                                    </div>
                                    <div class="widget-detail-2 text-end float-end">
                                        <h2 class="fw-normal mb-1"> {{ $total_orders }} </h2>
                                        <p class="text-muted mb-3">Total Orders</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="col-xl-3 col-md-6">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="header-title mt-0 mb-3">Returns / Exchanges</h4>

                                <div class="widget-box-2">
                                    <div class="widget-detail-2 text-start float-start">
                                        <h2 class="fw-normal mb-1"> {{ $today_returns }} </h2>
                                        <p class="text-muted mb-3">Today's Returns</p>
                                    </div>
                                    <div class="widget-detail-2 text-end float-end">
                                        <h2 class="fw-normal mb-1"> {{ $total_returns }} </h2>
                                        <p class="text-muted mb-3">Total Returns</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                    </div>



                    <div class="col-xl-3 col-md-6">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="header-title mt-0 mb-3">Revenue</h4>

                                <div class="widget-box-2">
                                    <div class="widget-detail-2 text-start float-start">
                                        <h2 class="fw-normal mb-1"> {{ $today_sales }} </h2>
                                        <p class="text-muted mb-3">Today Sales</p>
                                    </div>
                                    <div class="widget-detail-2 text-end float-end">
                                        <h2 class="fw-normal mb-1"> {{ $total_sales }} </h2>
                                        <p class="text-muted mb-3">Total Sales</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card">
                            <div class="card-body widget-user">
                                <div class="text-center">
                                    <h2 class="fw-normal text-primary" data-plugin="counterup"> {{ $vendors_garage }}</h2>
                                    <h5>Today's Vendor Registrations - Garage</h5>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card">
                            <div class="card-body widget-user">
                                <div class="text-center">
                                    <h2 class="fw-normal text-primary" data-plugin="counterup"> {{ $vendors_seller }}</h2>
                                    <h5>Today's Vendor Registrations - Seller</h5>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card">
                            <div class="card-body widget-user">
                                <div class="text-center">
                                    <h2 class="fw-normal text-primary" data-plugin="counterup"> {{ $approved_vendors }}
                                    </h2>
                                    <h5>Total Approved Vendors</h5>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card">
                            <div class="card-body widget-user">
                                <div class="text-center">
                                    <h2 class="fw-normal text-primary" data-plugin="counterup"> {{ $pending_vendors }}</h2>
                                    <h5>Total Pending Vendors</h5>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card">
                            <div class="card-body widget-user">
                                <div class="text-center">
                                    <h2 class="fw-normal text-primary" data-plugin="counterup"> {{ $user_individual }}</h2>
                                    <h5>Today's User Registrations - Individual</h5>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card">
                            <div class="card-body widget-user">
                                <div class="text-center">
                                    <h2 class="fw-normal text-primary" data-plugin="counterup"> {{ $user_garage }}</h2>
                                    <h5>Today's User Registrations - Garage</h5>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card">
                            <div class="card-body widget-user">
                                <div class="text-center">
                                    <h2 class="fw-normal text-primary" data-plugin="counterup"> {{ $total_user_individual }}
                                    </h2>
                                    <h5>Total Users - Individuals</h5>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card">
                            <div class="card-body widget-user">
                                <div class="text-center">
                                    <h2 class="fw-normal text-primary" data-plugin="counterup"> {{ $total_user_garage }}
                                    </h2>
                                    <h5>Total Users - Garage</h5>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="row">
                    <div class="col-xl-4 col-md-6">
                        <div class="card">
                            <h4 class="card-header">Top Selling Parts</h4>
                            <div class="card-body">
                                @foreach($topSellingProducts as $tsp)
                                    <h5 class="mt-0">{{ $tsp->title }} <span class="text-primary float-end">{{$tsp->total_sales}}</span></h5>
                                @endforeach
                            </div>
                        </div>
                       
                    </div>

                    <div class="col-xl-4 col-md-6">
                        <div class="card">
                            <h4 class="card-header">Top Selling Vendors</h4>
                            <div class="card-body">
                                @foreach($topSellingVendors as $tsv)
                                    <h5 class="mt-0">{{ $tsv->business_name }} <span class="text-primary float-end">{{$tsv->total_sales}}</span></h5>
                                @endforeach
                            </div>
                        </div>
                       
                    </div>

                    <div class="col-xl-4 col-md-6">
                        <div class="card">
                            <h4 class="card-header">Top Selling Makes</h4>
                            <div class="card-body">
                                @foreach($topSellingProducts as $tsp)
                                    <h5 class="mt-0">{{ $tsp->make }} <span class="text-primary float-end">{{$tsv->total_sales}}</span></h5>
                                @endforeach
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
            <!-- container-fluid -->
        </div>
        <!-- content -->
        @include('admin.includes.footer')
    @section('footer-scripts')
        {{-- <script src="{{ asset('assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script> --}}
    @endsection
</div>
@endsection
