@extends('supplier.layout')
@section('content')
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="row"> @for($i=1; $i<=8; $i++) <div class="col-md-4 col-12">
            <div class="card">
                    <div class="card-body">
                    

                        <h4 class="header-title mt-0 mb-3">Sales Analytics</h4>

                        <div class="widget-box-2">
                            <div class="widget-detail-2 text-end">
                                <span class="badge bg-success rounded-pill float-start mt-3">32% <i
                                        class="mdi mdi-trending-up"></i> </span>
                                <h2 class="fw-normal mb-1"> 8451 </h2>
                                <p class="text-muted mb-3">Revenue today</p>
                            </div>
                            <div class="progress progress-bar-alt-success progress-sm">
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="77"
                                    aria-valuemin="0" aria-valuemax="100" style="width: 77%;">
                                    <span class="visually-hidden">77% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <!-- <div class="card card-body">
            <h4 class="card-title">Products</h4>
            <p class="card-text">This is a wider card with supporting text below as a
              natural lead-in to additional content. This card has even longer content
              than the first to show that equal height action.</p>
            <p class="card-text"> <small class="text-muted">Last updated 3 mins ago</small> </p>
          </div> -->
            </div>
            @endfor
        </div>
        <!-- end row -->
    </div>

    <!-- container-fluid -->

</div>
</div>
<!-- content -->

<!-- Footer Start -->
@include('supplier.includes.footer')
<!-- end Footer -->

</div>
@endsection