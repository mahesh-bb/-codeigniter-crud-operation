<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?= $title; ?></title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link href="<?= base_url(); ?>assets/frontend/img/favicon.png" rel="icon">
  <link href="<?= base_url(); ?>assets/frontend/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="<?= base_url(); ?>assets/frontend/css/googlefonts.css" rel="stylesheet">
  <link href="<?= base_url(); ?>assets/frontend/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url(); ?>assets/frontend/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url(); ?>assets/frontend/vendor/aos/aos.css" rel="stylesheet">
  <link href="<?= base_url(); ?>assets/frontend/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="<?= base_url(); ?>assets/frontend/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="<?= base_url(); ?>assets/frontend/css/main.css" rel="stylesheet">
  <link href="<?= base_url(); ?>assets/frontend/css/toastr.min.css" rel="stylesheet">
  <link href="<?= base_url(); ?>assets/frontend/css/bootstrap-datepicker.min.css" rel="stylesheet">
  <link href="<?= base_url(); ?>assets/frontend/css/select2.min.css" rel="stylesheet">
  <link href="<?= base_url(); ?>assets/frontend/css/custome.css" rel="stylesheet">

  <!-- js script -->
<script src="<?= base_url(); ?>assets/frontend/js/jquery.min.js"></script>
<script src="<?= base_url(); ?>assets/frontend/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url(); ?>assets/frontend/vendor/aos/aos.js"></script>
<script src="<?= base_url(); ?>assets/frontend/vendor/glightbox/js/glightbox.min.js"></script>
<script src="<?= base_url(); ?>assets/frontend/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="<?= base_url(); ?>assets/frontend/vendor/swiper/swiper-bundle.min.js"></script>
<script src="<?= base_url(); ?>assets/frontend/js/main.js"></script>
<script src="<?= base_url(); ?>assets/frontend/js/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url(); ?>assets/frontend/js/select2.min.js"></script>
<script src="<?= base_url(); ?>assets/frontend/js/toastr.js"></script>

</head>
<style type="text/css">
  /* The message box is shown when the user clicks on the password field */
#message {
  display:none;
}

.valid {
  color: green;
}

.valid:before {
  content: "✔";
}

/* Add a red text color and an "x" when the requirements are wrong */
.invalid {
  color: red;
}

.invalid:before {
  content: "✖";
}
</style>

<script type="text/javascript">
  var base_url ='<?= base_url() ?>';
</script>
<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <a href="<?= base_url() ?>" class="logo d-flex align-items-center me-auto me-lg-0">
        <div class="brand-logo"><img src="<?= base_url() ?>assets/backend/images/logo.svg" alt="logo"></div>
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="<?= base_url(); ?>">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="<?= base_url()?>contact">Contact</a></li>
        </ul>
      </nav><!-- .navbar -->
      <?php if($this->session->userdata('id')){ ?>
        <a class="btn-book-a-table profile-btns" href="<?= base_url() ?>myprofile">MyProfile</a>
        <a class="btn-book-a-table login-btns" href="<?= base_url() ?>login/logout">Logout</a>  
        <?php }else{ ?>
          <a class="btn-book-a-table login-btns" href="<?= base_url() ?>login">Login</a>
      <?php  }  ?>
      
      
      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

    </div>
  </header><!-- End Header -->