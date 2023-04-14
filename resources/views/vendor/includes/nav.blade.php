@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::guard('vendor')->user();
@endphp
<div class="left-side-menu">
    <div class="h-100" data-simplebar>
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul id="side-menu">

                <li class="{{ $nav == 'dashboard' ? 'menuitem-active' : '' }}">
                    <a href="{{ route('vendor-dashboard') }}" class="{{ $nav == 'dashboard' ? 'active' : '' }}">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li class="menu-title mt-2">Sales</li>
                <li class="{{ $nav == 'order' ? 'menuitem-active' : '' }}">
                    <a href="{{ route('vendor-orders') }}" class="{{ $nav == 'order' ? 'active' : '' }}">
                        <i class="mdi mdi-cart"></i>
                        <span> Orders </span>
                    </a>
                </li>

                <li class="{{ $nav == 'return' ? 'menuitem-active' : '' }}">
                    <a href="{{ route('vendor-returns') }}" class="{{ $nav == 'return' ? 'active' : '' }}">
                        <i class="mdi mdi-autorenew"></i>
                        <span> Returns </span>
                    </a>
                </li>

                <li class="menu-title mt-2">Products</li>
                <li class="{{ $nav == 'product' ? 'menuitem-active' : '' }}">
                    <a href="{{ route('vendor-product') }}" class="{{ $nav == 'product' ? 'active' : '' }}"> <i
                            class="mdi mdi-cube"></i>
                        <span> My Products </span>
                    </a>
                </li>

                <li class="menu-title mt-2">Reports & Stats</li>
                <li> 
                    <a href="#"> 
                        <i class="mdi mdi-format-list-checkbox"></i> <span> Reports </span>
                    </a> 
                </li>

                <li class="{{ $nav == 'review' ? 'menuitem-active' : '' }}">
                    <a href="{{ route('vendor-reviews') }}" class="{{ $nav == 'review' ? 'active' : '' }}">
                        <i class="mdi mdi-account-group"></i>
                        <span> Client Reviews </span>
                    </a>
                </li>

                {{-- <li> 
                    <a href="#"> 
                        <i class="mdi mdi-format-list-checkbox"></i> <span> Notifications </span>
                    </a> 
                </li> --}}
                <li class="menu-title mt-2">Reports & Stats</li>
                <li class="{{ $nav == 'account' ? 'menuitem-active' : '' }}">
                    <a href="{{ route('vendor-account-setting') }}" class="{{ $nav == 'account' ? 'active' : '' }}">
                        <i class="mdi mdi-cog"></i>
                        <span> Account Settings </span>
                    </a>
                </li>
                <li class="{{ $nav == 'bank' ? 'menuitem-active' : '' }}"> 
                    <a  href="{{ route('vendor-account-bank') }}" class="{{ $nav == 'bank' ? 'active' : '' }}"> 
                        <i class="mdi mdi-bank"></i> <span> Bank Settings </span>
                    </a> 
                </li>
                <li class="{{ $nav == 'password' ? 'menuitem-active' : '' }}">
                    <a href="{{ route('vendor-account-change-password') }}" class="{{ $nav == 'password' ? 'active' : '' }}">
                        <i class="mdi mdi-lock"></i>
                        <span> Change Password </span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->

</div>
