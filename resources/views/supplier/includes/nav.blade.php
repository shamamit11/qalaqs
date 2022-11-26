<div class="left-side-menu">
    <div class="h-100" data-simplebar>
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul id="side-menu">

                <li class="{{ $nav == 'dashboard' ? 'menuitem-active' : '' }}">
                    <a href="{{ route('supplier-dashboard') }}" class="{{ $nav == 'dashboard' ? 'active' : '' }}">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li class="menu-title mt-2">Sales</li>
                <li> <a href="#"> <i class="mdi mdi-cart"></i> <span> Orders </span> </a> </li>
                <li> <a href="#"> <i class="mdi mdi-autorenew"></i> <span> Returns </span> </a> </li>

                <li class="menu-title mt-2">Products</li>
                <li>
                    <a href="#"> <i class="mdi mdi-cube"></i>
                        <span> Products </span>
                    </a>
                </li>
                
            </ul>
        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->

</div>