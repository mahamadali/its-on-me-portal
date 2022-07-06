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
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
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
              <a class="nav-link <?php echo ($this->uri->segment(1) == 'dashboard') ? 'active' : '' ?>" href="<?php echo base_url() ?>">
                <i class="ni ni-tv-2 text-primary"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link <?php echo ($this->uri->segment(1) == 'users') ? 'active' : '' ?>" href="<?php echo base_url('users') ?>">
                <i class="ni ni-user-run"></i>
                <span class="nav-link-text">Users</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo ($this->uri->segment(1) == 'merchants') ? 'active' : '' ?>" href="<?php echo base_url('merchants') ?>">
                <i class="ni ni-user-run"></i>
                <span class="nav-link-text">Merchants</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo ($this->uri->segment(1) == 'products') ? 'active' : '' ?>" href="<?php echo base_url('products') ?>">
                <i class="ni ni-user-run"></i>
                <span class="nav-link-text">Products</span>
              </a>
            </li>
            <li class="<?php echo ($this->uri->segment(1) == 'advertising') || ($this->uri->segment(1) == 'push-notifications') ? 'active' : '' ?>">

              <a href="#advertising" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="ni ni-notification-70" style="font-size: .9375rem;line-height: 1.5rem;min-width:1.2rem;"></i> Advertising</a>
              <ul class="collapse list-unstyled <?php echo ($this->uri->segment(1) == 'advertising') || ($this->uri->segment(1) == 'push-notifications')  ? 'show' : '' ?>" id="advertising">
                <li class="nav-item" style="padding-left:30px;">
                 <a class="nav-link <?php echo ($this->uri->segment(1) == 'advertising') ? 'active' : '' ?>" href="<?php echo base_url('advertising') ?>">
                    <i class="ni ni-app"></i>
                    <span class="nav-link-text">Advertising</span>
                  </a>
                </li>
                <li class="nav-item" style="padding-left:30px;">
                 <a class="nav-link <?php echo ($this->uri->segment(1) == 'push-notifications') ? 'active' : '' ?>" href="<?php echo base_url('push-notifications') ?>">
                    <i class="ni ni-app"></i>
                    <span class="nav-link-text">Push Notifications</span>
                  </a>
                </li>
              </ul>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link <?php //echo ($this->uri->segment(1) == 'product-categories') ? 'active' : '' ?>" href="<?php //echo base_url('product-categories') ?>">
                <i class="ni ni-app"></i>
                <span class="nav-link-text">Product Categories</span>
              </a>
            </li> -->
            <!-- <li class="nav-item">
              <a class="nav-link <?php //echo (empty($this->uri->segment(2)) && $this->uri->segment(1) == 'products') ? 'active' : '' ?>" href="<?php //echo base_url('products') ?>">
                <i class="ni ni-basket"></i>
                <span class="nav-link-text">Products</span>
              </a>
            </li> -->
            <!-- <li class="nav-item">
              <a class="nav-link <?php //echo (empty($this->uri->segment(2)) && $this->uri->segment(1) == 'settings') ? 'active' : '' ?>" href="<?php // echo base_url('setting') ?>">
                <i class="ni ni-settings"></i>
                <span class="nav-link-text">Settings</span>
              </a>
            </li> -->

            <!-- Settings -->

             <li class="<?php echo ($this->uri->segment(1) == 'product-categories') || ($this->uri->segment(1) == 'admins') || ($this->uri->segment(1) == 'brands') ? 'active' : '' ?>">

              <a href="#settings" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="ni ni-settings" style="font-size: .9375rem;line-height: 1.5rem;min-width:1.2rem;"></i> Settings</a>
              <ul class="collapse list-unstyled <?php echo ($this->uri->segment(1) == 'product-categories') || ($this->uri->segment(1) == 'admins') || ($this->uri->segment(1) == 'brands')  ? 'show' : '' ?>" id="settings">
                <li class="nav-item" style="padding-left:30px;">
                 <a class="nav-link <?php echo ($this->uri->segment(1) == 'product-categories') ? 'active' : '' ?>" href="<?php echo base_url('product-categories') ?>">
                    <i class="ni ni-app"></i>
                    <span class="nav-link-text">Categories</span>
                  </a>
                </li>
                <?php $this->load->helper('general'); $adminRole = getAdminData($_SESSION['admin']);
                      if($adminRole == 'superadmin'): ?>
                <li class="nav-item" style="padding-left:30px;">
                  <a class="nav-link <?php echo ($this->uri->segment(1) == 'admins') ? 'active' : '' ?>" href="<?php echo base_url('admin-list') ?>">
                    <i class="ni ni-map-big"></i>
                    <span class="nav-link-text">Admins</span>
                  </a>
                </li>
              <?php endif; ?>
              <li class="nav-item" style="padding-left:30px;">
                 <a class="nav-link <?php echo ($this->uri->segment(1) == 'brands') ? 'active' : '' ?>" href="<?php echo base_url('brands') ?>">
                    <i class="ni ni-app"></i>
                    <span class="nav-link-text">Brands</span>
                  </a>
                </li>
              </ul>
            </li> 


            <!-- Settings -->


            <li class="nav-item">
              <a class="nav-link <?php echo (empty($this->uri->segment(2)) && $this->uri->segment(1) == 'inquiries') ? 'active' : '' ?>" href="<?php echo base_url('inquiries') ?>">
                <i class="ni ni-email-83"></i>
                <span class="nav-link-text">Support</span>
              </a>
            </li>

            <!-- <li class="nav-item">
              <a class="nav-link <?php //echo (empty($this->uri->segment(2)) && $this->uri->segment(1) == 'vouchers') ? 'active' : '' ?>" href="<?php //echo base_url('vouchers') ?>">
                <i class="ni ni-tie-bow"></i>
                <span class="nav-link-text">Vouchers</span>
              </a>
            </li>
 -->
           <!--  <li class="nav-item">
              <a class="nav-link <?php //echo ($this->uri->segment(2) == 'reports') ? 'active' : '' ?>" href="<?php //echo base_url('reports') ?>">
                <i class="ni ni-check-bold"></i>

                <span class="nav-link-text">Report</span>
              </a>
            </li> -->
            <!-- <li class="nav-item">
              <a class="nav-link <?php echo ($this->uri->segment(2) == 'sport_players') ? 'active' : '' ?>" href="<?php echo base_url('sport_players') ?>">
                <i class="ni ni-single-02"></i>
                <span class="nav-link-text">Sport Players</span>
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
          <!-- Search form -->
         <!--  <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
            <div class="form-group mb-0">
              <div class="input-group input-group-alternative input-group-merge">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input class="form-control" placeholder="Search" type="text">
              </div>
            </div>
            <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </form> -->
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
            <!-- <li class="nav-item d-sm-none">
              <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                <i class="ni ni-zoom-split-in"></i>
              </a>
            </li> -->
          </ul>
          <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
            <li class="nav-item dropdown">
              <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="media align-items-center">
                  <span class="avatar avatar-sm rounded-circle">
                    <img alt="Image placeholder" src="<?php echo base_url('assets/img/IOM-logo.png') ?>">
                  </span>
                  <div class="media-body  ml-2  d-none d-lg-block">
                    <span class="mb-0 text-sm  font-weight-bold">Admin</span>
                  </div>
                </div>
              </a>
              <div class="dropdown-menu  dropdown-menu-right ">
                <div class="dropdown-header noti-title">
                  <h6 class="text-overflow m-0">Welcome!</h6>
                </div>
                <!-- <a href="#!" class="dropdown-item">
                  <i class="ni ni-single-02"></i>
                  <span>My profile</span>
                </a>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-settings-gear-65"></i>
                  <span>Settings</span>
                </a>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-calendar-grid-58"></i>
                  <span>Activity</span>
                </a>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-support-16"></i>
                  <span>Support</span>
                </a> -->
                <div class="dropdown-divider"></div>
                <a href="<?php echo base_url('profile/manageprofile') ?>" class="dropdown-item">
                  <i class="ni ni-single-02 text-yellow"></i>
                  <span>Profile</span>
                </a>
                <a href="<?php echo base_url('logout') ?>" class="dropdown-item">
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