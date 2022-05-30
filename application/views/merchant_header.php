<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="GUA">
  <meta name="author" content="GUA">
  <title><?php echo config_item('app_name'); ?></title>
  <!-- Favicon -->
  <link href="<?php echo base_url('assets/img/IOM-logo.png') ?>" rel="icon">
  <link href="<?php echo base_url('assets/img/brand/apple-touch-icon.png') ?>" rel="apple-touch-icon">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/nucleo/css/nucleo.css') ?>" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') ?>" type="text/css">
  <!-- Page plugins -->
  <!-- Argon CSS -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/argon.css?v=1.2.0') ?>" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/toastr.min.css') ?>" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/dataTable-style.css') ?>" type="text/css"> 
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  <style type="text/css">
    /* ---------------------------------------------------
    SIDEBAR STYLE
----------------------------------------------------- */

.wrapper {
  display: flex;
  width: 100%;
  align-items: stretch;
}

#sidebar {
  min-width: 250px;
  max-width: 250px;
  background: #7386D5;
  color: #fff;
  transition: all 0.3s;
}


#sidenav-collapse-main ul.components {
  padding: 20px 0;
  border-bottom: 1px solid #47748b;
}

#sidenav-collapse-main ul p {
  color: #fff;
  padding: 10px;
}

#sidenav-collapse-main ul li a {
  padding: 0.675rem 1.5rem;
  display: block;
  /*padding-left: 20px;*/
}

#sidenav-collapse-main ul li a:hover {
  color: #7386D5;
  background: #fff;
}

#sidenav-collapse-main ul li.active>a,
a[aria-expanded="true"] {
  color: #646464;
  /*background: #6d7fcc;*/
}

a[data-toggle="collapse"] {
  position: relative;
}

a {
  text-decoration: none;
  color: #646464;
  background-color: transparent;
  font-size: 15px;
}

.dropdown-toggle::after {
  display: block;
  position: absolute;
  top: 50%;
  right: 20px;
  transform: translateY(-50%);
}
.navbar-vertical .navbar-nav .nav-link > i
{
  min-width:1.2rem;
}

.navbar-vertical.navbar-expand-xs .navbar-nav > .nav-item > .nav-link.active{
  margin-left: 0px;
}

</style>
</head>

<body>
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header  align-items-center">
        <a class="navbar-brand" href="javascript:void(0)">
          <img src="<?php echo base_url('assets/img/IOM-logo.png') ?>" class="navbar-brand-img" alt="..." style="width:140px;">
        </a>
      </div>
      <div class="navbar-inner mt-4">
        <!-- Collapse --> 
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link <?php echo ($this->uri->segment(2) == 'dashboard') ? 'active' : '' ?>" href="<?php echo base_url('merchant/dashboard') ?>">
                <i class="ni ni-tv-2 text-primary"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link <?php echo ($this->uri->segment(2) == 'profile') ? 'active' : '' ?>" href="<?php echo base_url('merchant/profile') ?>">
                <i class="ni ni-user-run"></i>
                <span class="nav-link-text">Profile</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo ($this->uri->segment(2) == 'products') ? 'active' : '' ?>" href="<?php echo base_url('merchant/products') ?>">
                <i class="ni ni-user-run"></i>
                <span class="nav-link-text">Products</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo ($this->uri->segment(1) == 'advertising') ? 'active' : '' ?>" href="#">
                <i class="ni ni-notification-70"></i>
                <span class="nav-link-text">Redeem</span>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link <?php //echo ($this->uri->segment(1) == 'advertising') ? 'active' : '' ?>" href="<?php //echo base_url('advertising') ?>">
                <i class="ni ni-notification-70"></i>
                <span class="nav-link-text">Support</span>
              </a>
            </li> -->
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
  
          <!-- Navbar links -->
          <ul class="navbar-nav align-items-center  ml-md-auto ">
            <li class="nav-item d-xl-none">
              <!-- Sidenav toggler -->
              <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </div>
            </li>
         
          </ul>
          <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
            <li class="nav-item dropdown">
              <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="media align-items-center">
                  <span class="avatar avatar-sm rounded-circle">
                    <img alt="Image placeholder" src="<?php echo base_url('assets/img/IOM-logo.png') ?>">
                  </span>
                  <div class="media-body  ml-2  d-none d-lg-block">
                    <span class="mb-0 text-sm  font-weight-bold">Merchant</span>
                  </div>
                </div>
              </a>
              <div class="dropdown-menu  dropdown-menu-right ">
                <div class="dropdown-header noti-title">
                  <h6 class="text-overflow m-0">Welcome!</h6>
                </div>
               
                <div class="dropdown-divider"></div>
                <a href="<?php echo base_url('merchant/profile') ?>" class="dropdown-item">
                  <i class="ni ni-single-02 text-yellow"></i>
                  <span>Profile</span>
                </a>
                <a href="<?php echo base_url('merchant/logout') ?>" class="dropdown-item">
                  <i class="ni ni-user-run"></i>
                  <span>Logout</span>
                </a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Header -->