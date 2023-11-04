<?php //echo SKYDESH;  ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title><?=$title?> | <?= TITLE ?></title>
  <link rel="stylesheet" href="<?= base_url() ?>assets/backend/vendors/feather/feather.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/backend/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/backend/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/backend/css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?= base_url() ?>assets/backend/images/favicon.png" />
  <link href="<?= base_url(); ?>assets/frontend/css/toastr.min.css" rel="stylesheet">

  <script src="<?= base_url() ?>assets/backend/vendors/js/vendor.bundle.base.js"></script>
  <script src="<?= base_url() ?>assets/backend/js/hoverable-collapse.js"></script>
  <script src="<?= base_url() ?>assets/backend/js/template.js"></script>
  <script src="<?= base_url() ?>assets/backend/js/settings.js"></script>
  <script src="<?= base_url() ?>assets/backend/js/todolist.js"></script>
  <script src="<?= base_url(); ?>assets/frontend/js/toastr.js"></script>
  <script type="text/javascript">var base_url ='<?= base_url() ?>';</script>
  <script src="<?php  echo base_url(); ?>assets/frontend/js/custom.js"></script>
</head>
<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="<?= IMG_LOGO ?>" alt="logo">
              </div>
              <?php// print_r($cookies['email']); die; ?>
              <h6 class="font-weight-light">Sign in to continue.</h6>
              <form class="pt-3" id="login_form" method="post" >
                <div class="form-group emails">
                  <label>Email:</label>
                  <input type="text" name="email" value="<?= $cookies['email'] ?>" data-id="<?= $cookies['email'] ?>" class="form-control dnon" id="email" placeholder="Username">
                </div>
                <div class="form-group">
                  <label>Password:</label>
                  <input type="password" name="password" value="<?= $cookies['password'] ?>" class="form-control dnon" id="password" placeholder="Password">
                </div>
                  <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                    <input type="checkbox" name="rememberme" id="rememberme_check" value="<?= $cookies['rememberme'] ?>" <?php if($cookies['rememberme'] == 1){ echo  "checked";}?> >
                      Keep me signed in
                    </label>
                  </div>
                </div>
                

                <div class="mt-3">
                  <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" id="admin_btn_login"  name="admin_btn_login">SIGN IN</button>
                </div>
                 
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

  <script type="text/javascript">
    $(document).ready(function(){
        $("#admin_btn_login").click(function(event) {

      event.preventDefault();
      var login_validation = true;
      var email = $('#email').val();
      var password = $('#password').val();
      var url = base_url+"admin_login";
      var rememberme = $('#rememberme_check').is(':checked') ? 1 : 0
       
      if(email.length == "")
      {
        toastr.error("Please Enter Email");
        login_validation = false;
      }
      else if (!regex_pattern.test(email)) {
       toastr.error('Invalid Email ID');
        login_validation = false;
      }
      else if(password.length == "") 
      {
        toastr.error("Please Enter Password");
        login_validation = false;
      }
      
      if(login_validation == true)
      {
          $.ajax({
          type: 'POST',
          url: url,
          data: {
            email: email,
            password: password,
            rememberme: rememberme
          },
          dataType: 'json',
          success: function(response) {
            if (response.status == 'success') {
              toastr.success(response.message);
              setTimeout(function() {
                window.location.href = base_url+"<?= SKYDASH; ?>"+"/dashboard";
              }, 500);
            } else if (response.status == 'error') {
              toastr.error(response.message);
            }
          }

        });
      }
    });
    });
     
  </script>
 