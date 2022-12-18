@extends('supplier.layout')
@section('content')
<div class="content-page">
  <div class="content"> 
    
    <!-- Start Content-->
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-4">
          <div class="card text-center">
            <div class="card-body p-4">
              <div class="mb-4">
                <h4 class="text-uppercase mt-0">Pending Confirmation </h4>
              </div>
              <p class="text-muted font-14 mt-2"> Your account is under obervation. After approval of our team you can access further.</p>
            </div>
            <!-- end card-body --> 
          </div>
          <!-- end card --> 
          
        </div>
        <!-- end col --> 
      </div>
    </div>
    <!-- container-fluid --> 
    
  </div>
  <!-- content --> 
  
  <!-- Footer Start --> 
  @include('supplier.includes.footer') 
  <!-- end Footer --> 
  
</div>
@endsection