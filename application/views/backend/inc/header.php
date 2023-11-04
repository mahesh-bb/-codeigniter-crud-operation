<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?=$title?> | <?= TITLE ?></title>

  <link href="<?= base_url(); ?>assets/frontend/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url() ?>assets/backend/vendors/feather/feather.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/backend/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/backend/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/backend/css/vertical-layout-light/style.css">
  <link rel="shortcut icon" href="<?= base_url() ?>assets/backend/images/favicon.png" />
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/backend/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/backend/css/responsive.bootstrap4.min.css">
  <link href="<?= base_url(); ?>assets/frontend/css/toastr.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url() ?>assets/backend/css/flatpickr.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/backend/css/sweetalert2.css">

  
 <script src="<?= base_url(); ?>assets/frontend/js/jquery.min.js"></script> 
 <script src="<?= base_url() ?>assets/backend/vendors/js/vendor.bundle.base.js"></script>
 <!-- <script src="<?= base_url() ?>assets/backend/vendors/chart.js/Chart.min.js"></script>
 <script src="<?= base_url() ?>assets/backend/js/off-canvas.js"></script>
 <script src="<?= base_url() ?>assets/backend/js/hoverable-collapse.js"></script>
 <script src="<?= base_url() ?>assets/backend/js/template.js"></script>
 <script src="<?= base_url() ?>assets/backend/js/settings.js"></script>
 <script src="<?= base_url() ?>assets/backend/js/todolist.js"></script> -->
 <script src="<?= base_url() ?>assets/backend/js/dashboard.js"></script>
 <!-- <script src="<?= base_url() ?>assets/backend/js/Chart.roundedBarCharts.js"></script> -->
 <script src="<?= base_url() ?>assets/backend/js/jquery.dataTables.min.js"></script>
 <script src="<?= base_url() ?>assets/backend/js/dataTables.bootstrap4.min.js"></script>
 <script src="<?= base_url() ?>assets/backend/js/dataTables.responsive.min.js"></script>
 <script src="<?= base_url() ?>assets/backend/js/responsive.bootstrap4.min.js"></script>
 <script src="<?= base_url() ?>assets/backend/js/flatpickr.js"></script>

  <script src="<?= base_url(); ?>assets/frontend/js/toastr.js"></script>
  <script src="<?= base_url(); ?>assets/frontend/js/custom.js"></script> 
 
  <script src="<?= base_url(); ?>assets/backend/js/sweetalert2.js"></script>
   <script type="text/javascript">
      var base_url ='<?= base_url() ?>';
    </script>
</head>

<body>
  <div class="container-scroller">
      <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
          <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
              <a class="navbar-brand brand-logo mr-5" href="<?= base_url().SKYDASH.'/dashboard'?>"><img src="<?= base_url().IMG_LOGO ?>" class="mr-2" alt="logo"/></a>
             <!--  <a class="navbar-brand brand-logo-mini" href=""><img src="<?= base_url() ?>assets/backend/images/logo-mini.svg" alt="logo"/></a> -->
          </div>
          <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
              <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="icon-menu"></span>
              </button>
            
              <ul class="navbar-nav navbar-nav-right">
                  <li class="nav-item nav-profile dropdown">
                      <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                        <img src="<?= base_url() ?>assets/backend/images/faces/face28.jpg" alt="profile"/>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                        <a class="dropdown-item">
                          <i class="ti-settings text-primary"></i>
                          Profile
                        </a>
                        <a class="dropdown-item" href="<?= base_url().SKYDASH.'/logout'?>">
                          <i class="ti-power-off text-primary"></i>
                          Logout
                        </a>
                      </div>
                  </li>
              </ul>
              <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                <span class="icon-menu"></span>
              </button>
          </div>
      </nav>
      <div class="container-fluid page-body-wrapper">