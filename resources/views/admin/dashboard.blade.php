<!DOCTYPE html>
<html lang="en">

<head>
<title>Netacube | The Ultimate Business Management Solution </title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="description" content="#">
<meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
<meta name="author" content="#">
<link rel="icon" href="system/images/icon.png" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="dashboard/files/assets/icon/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="dashboard/files/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="dashboard/files/assets/icon/feather/css/feather.css">
<link rel="stylesheet" type="text/css" href="dashboard/files/assets/icon/icofont/css/icofont.css">
<link rel="stylesheet" type="text/css" href="dashboard/files/assets/css/sweetalert.css">
<link rel="stylesheet" type="text/css" href="dashboard/files/assets/icon/themify-icons/themify-icons.css">
<link rel="stylesheet" type="text/css" href="dashboard/files/assets/css/component.css">
<link rel="stylesheet" type="text/css" href="dashboard/files/assets/pages/j-pro/css/demo.css">
<link rel="stylesheet" type="text/css" href="dashboard/files/assets/pages/j-pro/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="dashboard/files/assets/pages/j-pro/css/j-pro-modern.css">
<link rel="stylesheet" type="text/css" href="dashboard/files/bower_components/cropper/dist/cropper.css">
<link rel="stylesheet" type="text/css" href="dashboard/files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="dashboard/files/assets/pages/data-table/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="dashboard/files/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="dashboard/files/assets/pages/data-table/extensions/buttons/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="dashboard/files/assets/css/style.css">
<link rel="stylesheet" type="text/css" href="dashboard/files/assets/css/jquery.mCustomScrollbar.css">
<link rel="stylesheet" type="text/css" href="dashboard/files/bower_components/lightbox2/dist/css/lightbox.min.css">
<link rel="stylesheet" type="text/css" href="dashboard/custom/css/fixedColumns.css">

</head>
<body>
<div class="theme-loader">
<div class="ball-scale">
<div class="contain">
<div class="ring">
<div class="frame"></div>
</div>
<div class="ring">
<div class="frame"></div>
</div>
<div class="ring">
<div class="frame"></div>
</div>
<div class="ring">
<div class="frame"></div>
</div>
<div class="ring">
<div class="frame"></div>
</div>
<div class="ring">
<div class="frame"></div>
</div>
<div class="ring">
<div class="frame"></div>
</div>
<div class="ring">
<div class="frame"></div>
</div>
<div class="ring">
<div class="frame"></div>
</div>
<div class="ring">
<div class="frame"></div>
</div>
</div>
</div>
</div>

<div id="pcoded" class="pcoded">
<div class="pcoded-overlay-box"></div>
<div class="pcoded-container navbar-wrapper">
<nav class="navbar header-navbar pcoded-header">
<div class="navbar-wrapper">
<div class="navbar-logo">
<a class="mobile-menu" id="mobile-collapse" href="#!">
<i class="feather icon-menu"></i>
</a>
<a href="admin-dashboard">
<img class="img-fluid" src="system/images/netacube.png" style="height:37px;" alt="#" />
</a>
<a class="mobile-options">
<i class="feather icon-more-horizontal"></i>
</a>
</div>
<div class="navbar-container">
<ul class="nav-left">
<li class="header-search">
<div class="main-search morphsearch-search">
<div class="input-group">
<span class="input-group-addon search-close"><i class="feather icon-x"></i></span>
<input type="text" class="form-control">
<span class="input-group-addon search-btn"><i class="feather icon-search"></i></span>
</div>
</div>
</li>
<li>
<a href="#!" onclick="javascript:toggleFullScreen()">
<i class="feather icon-maximize full-screen"></i>
</a>
</li>
</ul>
<ul class="nav-right">

<li class="user-profile header-notification">
<div class="dropdown-primary dropdown">
<div class="dropdown-toggle" data-toggle="dropdown">
<img src="#" class="img-radius" alt="">
<span>
<i class="feather icon-user" style="font-size:20px"></i>  {{Auth::user()->username}}
</span>
<i class="feather icon-chevron-down"></i>
</div>
<ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">

<li>
<a href="admin-profile">
<i class="feather icon-user"></i> Profile
</a>
</li>

<li>
<a href="/">
<i class="feather icon-log-out"></i> Logout
</a>
</li>

</ul>
</div>
</li>
</ul>
</div>
</div>
</nav>


<div class="pcoded-main-container">
<div class="pcoded-wrapper">
<nav class="pcoded-navbar">
<div class="pcoded-inner-navbar main-menu">
<div class="pcoded-navigatio-lavel" style="letter-spacing:10px;">ADMIN</div>
<ul class="pcoded-item pcoded-left-item">


<li class="pcoded-hasmenu    
  {{request()->is('admin-dashboard') ? 'active pcoded-trigger' : '' }} 
  {{request()->is('app-data') ? 'active pcoded-trigger' : '' }} 
  {{request()->is('categories') ? 'active pcoded-trigger' : '' }} 
  {{request()->is('users') ? 'active pcoded-trigger' : '' }} 
  {{request()->is('employees') ? 'active pcoded-trigger' : '' }} 
  {{request()->is('users-roles') ? 'active pcoded-trigger' : '' }}
  {{request()->is('branches') ? 'active pcoded-trigger' : '' }}
  {{request()->is('business-sector') ? 'active pcoded-trigger' : '' }}
  {{request()->is('vat-statuses') ? 'active pcoded-trigger' : '' }}
  {{request()->is('business-categories') ? 'active pcoded-trigger' : '' }}
  {{request()->is('suppliers') ? 'active pcoded-trigger' : '' }}
 ">
<a href="javascript:void(0)">
<span class="pcoded-micon"><i class="feather icon-align-center"></i></span>
<span class="pcoded-mtext">General</span>
</a>
<ul class="pcoded-submenu">

<li class="{{request()->is('admin-dashboard') ? 'active' : '' }} ">
<a href="admin-dashboard">
<span class="pcoded-mtext">Home</span>
</a>
</li>

<li class="  {{request()->is('app-data') ? 'active' : '' }}  ">
<a href="app-data">
<span class="pcoded-mtext">Company</span>
</a>
</li>



<li class="{{request()->is('business-sector') ? 'active' : '' }} ">
<a href="business-sector">
<span class="pcoded-mtext">Sectors</span>
</a>
</li>



<li class="{{request()->is('business-categories') ? 'active' : '' }} ">
<a href="business-categories">
<span class="pcoded-mtext">Categories</span>
</a>
</li>



<li class="{{request()->is('branches') ? 'active' : '' }}">
<a href="branches">
<span class="pcoded-mtext">Branches</span>
</a>
</li>


<li class="{{request()->is('employees') ? 'active' : '' }} ">
<a href="employees">
<span class="pcoded-mtext">Employees</span>
</a>
</li>


<li class="{{request()->is('users-roles') ? 'active' : '' }}">
<a href="users-roles">
<span class="pcoded-mtext">Roles</span>
</a>
</li>

<li class="{{request()->is('users') ? 'active' : '' }}">
<a href="users">
<span class="pcoded-mtext">Users</span>
</a>
</li>



<li class="{{request()->is('vat-statuses') ? 'active' : '' }}">
<a href="vat-statuses">
<span class="pcoded-mtext">VAT</span>
</a>
</li>



<li class="{{request()->is('suppliers') ? 'active' : '' }}">
<a href="suppliers">
<span class="pcoded-mtext">Suppliers</span>
</a>
</li>



</ul>
</li>





<li class="pcoded-hasmenu
  {{request()->is('admin-wholesale-baseproducts') ? 'active pcoded-trigger' : '' }} 
  {{request()->is('admin-wholesale-branch-products') ? 'active pcoded-trigger' : '' }} 
  {{request()->is('admin-wholesale-product-tracker') ? 'active pcoded-trigger' : '' }} 
  {{request()->is('admin-wholesale-product-supplies') ? 'active pcoded-trigger' : '' }} 
  {{request()->is('admin-wholesale-clients') ? 'active pcoded-trigger' : '' }} 

">
<a href="javascript:void(0)">
<span class="pcoded-micon"> <i class="fa fa-truck"></i></span>
<span class="pcoded-mtext">Wholesale</span>
</a>
<ul class="pcoded-submenu">

<li class="{{request()->is('admin-wholesale-baseproducts') ? 'active' : '' }}">
<a href="admin-wholesale-baseproducts">
<span class="pcoded-mtext">Base</span>
</a>
</li>


<li class="{{request()->is('admin-wholesale-branch-products') ? 'active' : '' }}" >
<a href="admin-wholesale-branch-products">
<span class="pcoded-mtext">Products</span>
</a>
</li>



<li class="{{request()->is('admin-wholesale-product-tracker') ? 'active' : '' }}" >
<a href="admin-wholesale-product-tracker">
<span class="pcoded-mtext">Logs</span>
</a>
</li>


<li class="{{request()->is('admin-wholesale-product-supplies') ? 'active' : '' }}" >
<a href="admin-wholesale-product-supplies">
<span class="pcoded-mtext">Supplies</span>
</a>
</li>



<li  class="{{request()->is('admin-wholesale-clients') ? 'active' : '' }}">
<a href="admin-wholesale-clients">
<span class="pcoded-mtext">Clients</span>
</a>
</li>

<!--<li >
<a href="admin-wholesale-product-supplies">
<span class="pcoded-mtext">Sales</span>
</a>
</li>-->



<!--<li >
<a href="admin-wholesale-product-supplies">
<span class="pcoded-mtext">Documents</span>
</a>
</li>-->


</ul>
</li>






<li class="pcoded-hasmenu
  {{request()->is('admin-retail-baseproducts') ? 'active pcoded-trigger' : '' }} 
  {{request()->is('admin-retail-branch-products') ? 'active pcoded-trigger' : '' }} 
  {{request()->is('admin-retail-product-tracker') ? 'active pcoded-trigger' : '' }} 
  {{request()->is('admin-retail-product-supplies') ? 'active pcoded-trigger' : '' }} 
  {{request()->is('admin-retail-clients') ? 'active pcoded-trigger' : '' }} 
   {{request()->is('admin-retail-stocktaking') ? 'active pcoded-trigger' : '' }} 
">
<a href="javascript:void(0)">
<span class="pcoded-micon"> <i class="fa fa-shopping-cart"></i></span>
<span class="pcoded-mtext">Retail</span>
</a>
<ul class="pcoded-submenu">

<li class="{{request()->is('admin-retail-baseproducts') ? 'active' : '' }}">
<a href="admin-retail-baseproducts">
<span class="pcoded-mtext">Base</span>
</a>
</li>


<li class="{{request()->is('admin-retail-branch-products') ? 'active' : '' }}" >
<a href="admin-retail-branch-products">
<span class="pcoded-mtext">Products</span>
</a>
</li>



<li class="{{request()->is('admin-retail-product-tracker') ? 'active' : '' }}" >
<a href="admin-retail-product-tracker">
<span class="pcoded-mtext">Logs</span>
</a>
</li>


<li class="{{request()->is('admin-retail-product-supplies') ? 'active' : '' }}" >
<a href="admin-retail-product-supplies">
<span class="pcoded-mtext">Supplies</span>
</a>
</li>



<li  class="{{request()->is('admin-retail-openingstock') ? 'active' : '' }}">
<a href="admin-retail-openingstock">
<span class="pcoded-mtext">Openingstock</span>
</a>
</li>


<!--<li  class="{{request()->is('admin-retail-openingstock-data') ? 'active' : '' }}">
<a href="admin-retail-openingstock-data">
<span class="pcoded-mtext">OpeningStock</span>
</a>
</li>-->




<!--<li  class="{{request()->is('admin-retail-clients') ? 'active' : '' }}">
<a href="admin-retail-clients">
<span class="pcoded-mtext">Clients</span>
</a>
</li>-->



<!--<li >
<a href="admin-wholesale-product-supplies">
<span class="pcoded-mtext">Sales</span>
</a>
</li>-->



<!--<li >
<a href="admin-wholesale-product-supplies">
<span class="pcoded-mtext">Documents</span>
</a>
</li>-->


</ul>
</li>








<li class="pcoded-hasmenu 
{{request()->is('admin-homepage-settings') ? 'active pcoded-trigger' : '' }} 

">
<a href="javascript:void(0)">
<span class="pcoded-micon"><i class="fa fa-cog"></i></span>
<span class="pcoded-mtext">Settings</span>
</a>
<ul class="pcoded-submenu">


<li class="{{request()->is('admin-homepage-settings') ? 'active' : '' }} ">
<a href="admin-homepage-settings">
<span class="pcoded-mtext">Homepage</span>
</a>
</li>

</ul>
</li>



</ul>
</div>
</nav>





<div class="pcoded-content">
<div class="pcoded-inner-content">
<div class="main-body">
<div class="page-wrapper">
<div class="page-body">





@yield('content',View::make('admin.default'))
      




</div>
</div>
</div>
</div>
</div>

<script type="text/javascript" src="dashboard/files/bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="dashboard/files/bower_components/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="dashboard/files/bower_components/popper.js/dist/umd/popper.min.js"></script>
<script type="text/javascript" src="dashboard/files/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script type="text/javascript" src="dashboard/files/bower_components/jquery-slimscroll/jquery.slimscroll.js"></script>

<script type="text/javascript" src="dashboard/files/bower_components/modernizr/modernizr.js"></script>

<script type="text/javascript" src="dashboard/files/bower_components/chart.js/dist/Chart.js"></script>


<script src="dashboard/files/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="dashboard/files/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="dashboard/files/assets/pages/data-table/js/jszip.min.js"></script>
<script src="dashboard/files/assets/pages/data-table/js/pdfmake.min.js"></script>
<script src="dashboard/files/assets/pages/data-table/js/vfs_fonts.js"></script>
<script src="dashboard/files/assets/pages/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script src="dashboard/files/assets/pages/data-table/extensions/buttons/js/buttons.flash.min.js"></script>
<script src="dashboard/files/assets/pages/data-table/extensions/buttons/js/jszip.min.js"></script>
<script src="dashboard/files/assets/pages/data-table/extensions/buttons/js/vfs_fonts.js"></script>
<script src="dashboard/files/assets/pages/data-table/extensions/buttons/js/buttons.colVis.min.js"></script>
<script src="dashboard/files/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="dashboard/files/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="dashboard/files/assets/pages/data-table/js/dataTables.bootstrap4.min.js"></script>
<script src="dashboard/files/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="dashboard/files/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>


<script src="dashboard/files/assets/pages/data-table/extensions/buttons/js/extension-btns-custom.js"></script>



<script src="dashboard/files/assets/pages/widget/amchart/amcharts.js"></script>
<script src="dashboard/files/assets/pages/widget/amchart/serial.js"></script>
<script src="dashboard/files/assets/pages/widget/amchart/light.js"></script>
<script src="dashboard/files/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="dashboard/files/assets/js/SmoothScroll.js"></script>
<script src="dashboard/files/assets/js/pcoded.min.js"></script>

<script src="dashboard/files/assets/js/vartical-layout.min.js"></script>
<script type="text/javascript" src="dashboard/files/assets/pages/dashboard/custom-dashboard.js"></script>
<script type="text/javascript" src="dashboard/files/assets/js/script.min.js"></script>


<script type="text/javascript" src="dashboard/files/assets/js/classie.js"></script>


<script type="text/javascript" src="dashboard/files/bower_components/jquery-ui/jquery-ui.min.js"></script>

<script type="text/javascript" src="dashboard/files/assets/pages/j-pro/js/jquery.ui.min.js"></script>
<script type="text/javascript" src="dashboard/files/assets/pages/j-pro/js/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="dashboard/files/assets/pages/j-pro/js/jquery.j-pro.js"></script>


<script type="text/javascript" src="dashboard/files/bower_components/switchery/dist/switchery.min.js"></script>




<script src="dashboard/files/bower_components/cropper/dist/cropper.min.js"></script>
<script src="dashboard/files/assets/pages/cropper/croper.js"></script>
<script type="text/javascript" src="dashboard/files/bower_components/lightbox2/dist/js/lightbox.min.js"></script>

<link rel="stylesheet" type="text/css" href="dashboard/files/bower_components/multiselect/css/multi-select.css" />
<link rel="stylesheet" type="text/css" href="dashboard/files/bower_components/bootstrap-multiselect/dist/css/bootstrap-multiselect.css" />
<link rel="stylesheet" href="dashboard/files/bower_components/select2/dist/css/select2.min.css" />

<script type="text/javascript" src="dashboard/files/bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript" src="dashboard/files/bower_components/bootstrap-multiselect/dist/js/bootstrap-multiselect.js"></script>
<script type="text/javascript" src="dashboard/files/bower_components/multiselect/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="dashboard/files/assets/js/jquery.quicksearch.js"></script>
<script type="text/javascript" src="dashboard/files/assets/pages/advance-elements/select2-custom.js"></script>

<script src="papaparse/papaparse.min.js"></script>
</body>
</html>