<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ERP</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/erp-theme/backend/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <!-- Google fonts - Popppins for copy-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,800">
    <!-- orion icons-->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/erp-theme/backend/css/orionicons.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/erp-theme/backend/css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/erp-theme/backend/css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="<?php echo base_url() ?>assets/erp-theme/backend/img/favicon.png?3">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body>
    <!-- navbar-->
    <header class="header">
      <nav class="navbar navbar-expand-lg px-4 py-2 bg-white shadow"><a href="#" class="sidebar-toggler text-gray-500 mr-4 mr-lg-5 lead"><i class="fas fa-align-left"></i></a><a href="index.html" class="navbar-brand font-weight-bold text-uppercase text-base">ERP Dashboard</a>
        <ul class="ml-auto d-flex align-items-center list-unstyled mb-0">
          <li class="nav-item dropdown ml-auto"><a id="userInfo" href="http://example.com" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><img src="<?php echo base_url() ?>assets/erp-theme/backend/img/avatar-6.jpg" alt="Jason Doe" style="max-width: 2.5rem;" class="img-fluid rounded-circle shadow"></a>
            <div aria-labelledby="userInfo" class="dropdown-menu"><a href="#" class="dropdown-item"><strong class="d-block text-uppercase headings-font-family">Admin</strong><small></small></a>
              <div class="dropdown-divider"></div><a href="<?php echo base_url('erp/admin/setting/changePassword') ?>" class="dropdown-item">Change Password</a>
              <div class="dropdown-divider"></div><a href="<?php echo base_url('erp/admin/dashboard/logout') ?>" class="dropdown-item">Logout</a>
            </div>
          </li>
        </ul>
      </nav>
    </header>
    <div class="d-flex align-items-stretch">
      <div id="sidebar" class="sidebar py-3">
        <div class="text-gray-400 text-uppercase px-3 px-lg-4 py-4 font-weight-bold small headings-font-family">MAIN</div>
          <ul class="sidebar-menu list-unstyled">
              <li class="sidebar-list-item">
                <a href="<?php echo  base_url('erp/admin/dashboard') ?>" class="sidebar-link text-muted <?php echo (isset($active) && $active == 'dashboard') ? 'active':''; ?>"><i class="o-home-1 mr-3 text-gray"></i><span>Dashboard</span>
                </a>
              </li>
              <li class="sidebar-list-item">
                <a href="<?php echo  base_url('erp/admin/users/users') ?>" class="sidebar-link text-muted <?php echo (isset($active) && $active == 'users') ? 'active':''; ?>"><i class="o-user-1 mr-3 text-gray"></i><span>Users</span>
                </a>
              </li>
              <li class="sidebar-list-item">
                <a href="#" data-toggle="collapse" data-target="#orders" aria-expanded="false"aria-controls="orders" class="sidebar-link text-muted">
                    <i class="o-wireframe-1 mr-3 text-gray"></i>
                    <span>Inventory</span>
                </a>
                <div id="orders" class="collapse">
                  <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                    <li class="sidebar-list-item">
                      <a href="<?php echo base_url('erp/admin/orders') ?>" class="sidebar-link text-muted pl-lg-5 <?php echo (isset($active) && $active == 'all_orders') ? 'active':''; ?>">
                        Purchase Invoice
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="sidebar-list-item">
                <a href="#" data-toggle="collapse" data-target="#settings" aria-expanded="false"aria-controls="settings" class="sidebar-link text-muted <?php echo (isset($active) && $active == 'changePassword') ? 'active':''; ?>">
                    <i class="o-wireframe-1 mr-3 text-gray"></i>
                    <span>Settings</span>
                </a>
                <div id="settings" class="collapse">
                  <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                    <li class="sidebar-list-item <?php echo (isset($active) && $active == 'changePassword') ? 'active':''; ?>">
                      <a href="<?php echo base_url('erp/admin/setting/changePassword') ?>" class="sidebar-link text-muted pl-lg-5">
                        Change Password
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="sidebar-list-item"><a href="<?php echo base_url('erp/admin/dashboard/logout') ?>" class="sidebar-link text-muted"><i class="o-exit-1 mr-3 text-gray"></i><span>Logout</span></a></li>
          </ul>
      </div>


