@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::guard('vendor')->user();
    if($user->image) {
        $user_image = asset('/storage/vendor/' . $user->image);
    } 
    else {
        $user_image = asset('assets/admin/images/icon.png');
    }
@endphp

<div class="navbar-custom">
  <ul class="list-unstyled topnav-menu float-end mb-0">
      <li class="dropdown notification-list topbar-dropdown"> <a
              class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown"
              href="#" role="button" aria-haspopup="false" aria-expanded="false"> <img
                  src="{{ $user_image }}" alt="user-image" class="rounded-circle"> <span
                  class="pro-user-name ms-1"> {{ $user->business_name }} <i class="mdi mdi-chevron-down"></i>
              </span> </a>
          <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
              <!-- item-->
              <a href="{{ route('vendor-account-setting') }}" class="dropdown-item notify-item"> <i
                      class="fe-settings"></i> <span>Account Settings</span> </a>
              <a href="{{ route('vendor-account-change-password') }}" class="dropdown-item notify-item"> <i
                      class="fe-lock"></i> <span>Change Password</span> </a>
              <div class="dropdown-divider"></div>
              <a href="{{ route('vendor-logout') }}" class="dropdown-item notify-item"> <i class="fe-log-out"></i>
                  <span>Logout</span> </a>
          </div>
      </li>
  </ul>

  <!-- LOGO -->
  <div class="logo-box">
      <a href="{{ route('vendor-dashboard') }}" class="logo logo-light text-center">
          <span class="logo-sm">
              <img src="{{ asset('assets/admin/images/qalaqs-icon.png') }}" alt="" height="35">
          </span>
          <span class="logo-lg">
              <img src="{{ asset('assets/admin/images/qalaqs-logo.png') }}" alt="" height="45">
          </span>
      </a>
      <a href="{{ route('vendor-dashboard') }}" class="logo logo-dark text-center">
          <span class="logo-sm">
              <img src="{{ asset('assets/admin/images/qalaqs-icon.png') }}" alt="" height="35">
          </span>
          <span class="logo-lg">
              <img src="{{ asset('assets/admin/images/qalaqs-logo.png') }}" alt="" height="45">
          </span>
      </a>
  </div>

  <ul class="list-unstyled topnav-menu topnav-menu-left mb-0">
      <li>
          <button class="button-menu-mobile disable-btn waves-effect"> <i class="fe-menu"></i> </button>
      </li>
      <li>
          <a id="toggle-sidebar" data-id="0" href="javascript:void(0)">
              <h2 class="page-title-main wadex-page-title" style="padding-right: 0;">
                  <i class="mdi mdi-menu"></i>
              </h2>
          </a>
      </li>
      {{-- <li>
          <h4 class="page-title-main">{{ $page_title }}</h4>
      </li> --}}
  </ul>
  <div class="clearfix"></div>
</div>
