@include('admin.includes.metahead')
<body data-layout-color="light"  data-layout-mode="default" data-layout-size="fluid" data-topbar-color="light" data-leftbar-position="fixed" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='true'>
<div id="wrapper"> 
@include('admin.includes.top-bar')
@include('admin.includes.nav')
@yield('content')
</div>
@include('admin.includes.scripts')
@yield('footer-scripts')
</body>
</html>