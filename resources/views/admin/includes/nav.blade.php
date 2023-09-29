@php
    $isStandardAdmin = checkIfUserIsStandardUser();
    $isSuperAdmin = checkIfUserIsSuperAdmin();
@endphp

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

                @if ($isSuperAdmin)
                    <li class="{{ $nav == 'filemanager' ? 'menuitem-active' : '' }}">
                        <a href="{{ route('admin-filemanager') }}" class="{{ $nav == 'filemanager' ? 'active' : '' }}">
                            <i class="mdi mdi-folder-cog"></i>
                            <span> File Manager </span>
                        </a>
                    </li>
                @endif

                <li class="menu-title mt-2">Vendor</li>

                <li class="{{ $nav == 'vendor' ? 'menuitem-active' : '' }}">
                    <a href="{{ route('admin-vendor') }}" class="{{ $nav == 'vendor' ? 'active' : '' }}">
                        <i class="mdi mdi-account-group"></i>
                        <span> Vendors </span>
                    </a>
                </li>

                @if ($isSuperAdmin)


                    @if ($isSuperAdmin)
                        <li class="{{ $nav == 'report' ? 'menuitem-active' : '' }}"> <a
                                href="{{ route('admin-report-vendors') }}"> <i
                                    class="mdi mdi-format-list-checkbox"></i> <span> Reports </span>
                            </a> </li>
                    @endif

                    <li class="menu-title mt-2">Quotations / Inquiries</li>

                    <li class="{{ $nav == 'quote' ? 'menuitem-active' : '' }}">
                        <a href="{{ route('admin-quote') }}"
                            class="{{ $nav == 'quote' ? 'active' : '' }}">
                            <i class="mdi mdi-cart"></i>
                            <span> Quote Requests </span>
                        </a>
                    </li>

                    <li class="{{ $nav == 'inquiry' ? 'menuitem-active' : '' }}">
                        <a href="{{ route('admin-inquiry') }}"
                            class="{{ $nav == 'inquiry' ? 'active' : '' }}">
                            <i class="mdi mdi-cart"></i>
                            <span> Product Inquiries </span>
                        </a>
                    </li>
                    
                    {{-- <li class="{{ $nav == 'specialrequest' ? 'menuitem-active' : '' }}">
                        <a href="{{ route('admin-special-requests') }}"
                            class="{{ $nav == 'specialrequest' ? 'active' : '' }}">
                            <i class="mdi mdi-cart"></i>
                            <span> Special Requests </span>
                        </a>
                    </li> --}}

                    {{-- <li class="{{ $nav == 'order' ? 'menuitem-active' : '' }}">
                        <a href="{{ route('admin-orders') }}" class="{{ $nav == 'order' ? 'active' : '' }}">
                            <i class="mdi mdi-cart"></i>
                            <span> Sales / Orders </span>
                        </a>
                    </li> --}}

                    {{-- <li class="{{ $nav == 'return' ? 'menuitem-active' : '' }}">
                        <a href="{{ route('admin-returns') }}" class="{{ $nav == 'return' ? 'active' : '' }}">
                            <i class="mdi mdi-autorenew"></i>
                            <span> Returns </span>
                        </a>
                    </li> --}}
                @endif

                <li class="menu-title mt-2">Products</li>
                <li class="{{ $nav == 'product' ? 'menuitem-active' : '' }}">
                    <a href="{{ route('admin-product') }}" class="{{ $nav == 'product' ? 'active' : '' }}"> <i
                            class="mdi mdi-cube"></i>
                        <span class="badge bg-danger rounded-pill float-end">{{ getNewProductsCount() }}</span>
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

                {{-- <li class="{{ $nav == 'engine' ? 'menuitem-active' : '' }}">
                    <a href="{{ route('admin-engine') }}" class="{{ $nav == 'engine' ? 'active' : '' }}">
                        <i class="mdi mdi-alpha-e-circle"></i>
                        <span> Engines </span>
                    </a>
                </li> --}}

                {{-- <li class="{{ $nav == 'productImage' ? 'menuitem-active' : '' }}">
                    <a href="{{ route('admin-product-images') }}" class="{{ $nav == 'productImage' ? 'active' : '' }}">
                        <i class="mdi mdi-alpha-e-circle"></i>
                        <span> Product Images </span>
                    </a>
                </li> --}}

                @if ($isSuperAdmin)
                    <li class="menu-title mt-2">Customers</li>
                    <li class="{{ $nav == 'user' ? 'menuitem-active' : '' }}">
                        <a href="{{ route('admin-users') }}" class="{{ $nav == 'user' ? 'active' : '' }}">
                            <i class="mdi mdi-account-group"></i>
                            <span> Customers </span>
                        </a>
                    </li>


                    <li class="menu-title mt-2">Couriers</li>
                    <li class="{{ $nav == 'courier' ? 'menuitem-active' : '' }}">
                        <a href="{{ route('admin-couriers') }}" class="{{ $nav == 'courier' ? 'active' : '' }}">
                            <i class="mdi mdi-truck-delivery"></i>
                            <span> Couriers </span>
                        </a>
                    </li>

                    <li class="menu-title mt-2">App Configuration</li>
                    <li class="{{ $nav == 'banner' ? 'menuitem-active' : '' }}">
                        <a href="{{ route('admin-banner') }}" class="{{ $nav == 'banner' ? 'active' : '' }}">
                            <i class="mdi mdi-collage"></i>
                            <span> App Banners </span>
                        </a>
                    </li>

                    <li class="{{ $nav == 'garage' ? 'menuitem-active' : '' }}">
                        <a href="{{ route('admin-garage') }}" class="{{ $nav == 'garage' ? 'active' : '' }}">
                            <i class="mdi mdi-collage"></i>
                            <span> Garages </span>
                        </a>
                    </li>

                    <li class="{{ $nav == 'recovery' ? 'menuitem-active' : '' }}">
                        <a href="{{ route('admin-recovery') }}" class="{{ $nav == 'recovery' ? 'active' : '' }}">
                            <i class="mdi mdi-collage"></i>
                            <span> Recovery Services </span>
                        </a>
                    </li>

                    <li class="{{ $nav == 'autoservice' ? 'menuitem-active' : '' }}">
                        <a href="{{ route('admin-autoservice') }}" class="{{ $nav == 'autoservice' ? 'active' : '' }}">
                            <i class="mdi mdi-collage"></i>
                            <span> Auto Services </span>
                        </a>
                    </li>

                    <li class="{{ $nav == 'auction' ? 'menuitem-active' : '' }}">
                        <a href="{{ route('admin-auction') }}" class="{{ $nav == 'auction' ? 'active' : '' }}">
                            <i class="mdi mdi-collage"></i>
                            <span> Auctions </span>
                        </a>
                    </li>

                    <li class="menu-title mt-2">Configuration</li>
                    <li class="{{ $nav == 'systemuser' ? 'menuitem-active' : '' }}">
                        <a href="{{ route('admin-systemusers') }}" class="{{ $nav == 'systemuser' ? 'active' : '' }}">
                            <i class="mdi mdi-account-circle"></i>
                            <span> System Users </span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->

</div>
