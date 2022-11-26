<div class="left-side-menu">
    <div class="h-100" data-simplebar>
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul id="side-menu">

                <li class="{{ $nav == 'dashboard' ? 'menuitem-active' : '' }}">
                    <a href="{{ route('admin-dashboard') }}" class="{{ $nav == 'dashboard' ? 'active' : '' }}">
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
                        <span class="badge bg-success rounded-pill float-end">9</span>
                        <span> Products </span>
                    </a>
                </li>
                <li class="menu-title mt-2">Product Configuration</li>

                <li class="{{ $nav == 'category' ? 'menuitem-active' : '' }}">
                    <a href="{{ route('admin-category') }}" class="{{ $nav == 'category' ? 'active' : '' }}">
                        <i class="mdi mdi-collage"></i>
                        <span> Category </span>
                    </a>
                </li>

                <li class="{{ $nav == 'subcategory' ? 'menuitem-active' : '' }}">
                    <a href="{{ route('admin-subcategory') }}" class="{{ $nav == 'subcategory' ? 'active' : '' }}">
                        <i class="mdi mdi-axis-arrow"></i>
                        <span> Sub Category </span>
                    </a>
                </li>

                <li class="{{ $nav == 'brand' ? 'menuitem-active' : '' }}">
                    <a href="{{ route('admin-brand') }}" class="{{ $nav == 'brand' ? 'active' : '' }}">
                        <i class="mdi mdi-alpha-b-circle"></i>
                        <span> Brands </span>
                    </a>
                </li>
                <li class="{{ $nav == 'make' ? 'menuitem-active' : '' }}">
                    <a href="{{ route('admin-make') }}" class="{{ $nav == 'make' ? 'active' : '' }}">
                        <i class="mdi mdi-alpha-m-circle"></i>
                        <span> Makes </span>
                    </a>
                </li>

                <li class="{{ $nav == 'model' ? 'menuitem-active' : '' }}">
                    <a href="{{ route('admin-model') }}" class="{{ $nav == 'model' ? 'active' : '' }}">
                        <i class="mdi mdi-alpha-m-circle"></i>
                        <span> Models </span>
                    </a>
                </li>
                <li class="{{ $nav == 'year' ? 'menuitem-active' : '' }}">
                    <a href="{{ route('admin-year') }}" class="{{ $nav == 'year' ? 'active' : '' }}">
                        <i class="mdi mdi-alpha-y-circle"></i>
                        <span> Years </span>
                    </a>
                </li>
                <li class="{{ $nav == 'engine' ? 'menuitem-active' : '' }}">
                    <a href="{{ route('admin-engine') }}" class="{{ $nav == 'engine' ? 'active' : '' }}">
                        <i class="mdi mdi-alpha-e-circle"></i>
                        <span> Engines </span>
                    </a>
                </li>

                <li class="menu-title mt-2">Suppliers</li>

                <li class="{{ $nav == 'supplier' ? 'menuitem-active' : '' }}">
                    <a href="{{ route('admin-supplier') }}" class="{{ $nav == 'supplier' ? 'active' : '' }}">
                        <i class="mdi mdi-account-group"></i>
                        <span> Suppliers </span>
                    </a>
                </li>
                <li> <a href="#"> <i class="mdi mdi-format-list-checkbox"></i> <span> Reports </span>
                    </a> </li>

                <li class="menu-title mt-2">Customers</li>
                <li> <a href="#"> <i class="mdi mdi-account-group"></i> <span> Customers </span> </a>
                </li>

                <li class="menu-title mt-2">App Configuration</li>
                <li class="{{ $nav == 'banner' ? 'menuitem-active' : '' }}">
                    <a href="{{ route('admin-banner') }}" class="{{ $nav == 'banner' ? 'active' : '' }}">
                        <i class="mdi mdi-collage"></i>
                        <span> App Banners </span>
                    </a>
                </li>
                <li class="menu-title mt-2">General Configuration</li>
                <li> <a href="#"> <i class="mdi mdi-cogs"></i> <span> Site Settings </span> </a> </li>

            </ul>
        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->

</div>