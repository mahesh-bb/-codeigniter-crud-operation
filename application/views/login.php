 

  <main id="main">
    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">

        <div class="section-header page-title">
         <!--  <h2>Contact</h2> -->
          <p><span>Login</span></p>
        </div>

      
        <div class="php-email-form p-3 p-md-4 form-size">
          <form id="loginform" method="POST" >
          <!--  -->
            <div class="form-group">
              <label>Email/Username</label>
              <input type="text" class="form-control" name="username" id="username" placeholder="Enter Email Or User Name" required>
              <span class="text-danger"><?= form_error('username'); ?></span>
            </div>
            <div class="form-group">
              <label>Password</label>
             <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" required>
             <span class="text-danger"><?= form_error('password'); ?></span>
            </div>
           
            <div class="text-center"><button id="login_btn" class="save-btn" class="" name="login">Login</button></div>
            <p class="mt-2">Create New Account <a href="<?= base_url() ?>registration" class="url_link"><u>Click here</u></a></p>
            <span class="">Forget Password <a href="<?= base_url() ?>forgetpassword" class="url_link"><u>Click here</u></a></span>
          </form>
        </div>
        <!--End Contact Form -->

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->
  <script type="text/javascript">
    $("#login_btn").click(function(event) {
      event.preventDefault();
      validation_otp_error = true;
      var username = $('#username').val();
      var password = $('#password').val();
    
      var url = base_url+'login/login_process';
       if (username.length == '') {
          //toaster();
          toastr.error("Please Enter Email Or User Name");
          validation_otp_error = false;
        }
         
        else if(password.length == '') {
          //toaster();
          toastr.error("Please Enter Password");
          validation_otp_error = false;
        }

         if (validation_otp_error == true) {
          //console.log('ok');

          $.ajax({
          type: 'POST',
          url: url,
          data: {
            username: username,
            password: password
          },
          dataType: 'json',
          success: function(response) {
            if (response.status == 'success') {
              toaster();
              toastr.success(response.message);
              setTimeout(function() {
                window.location.href = base_url+"myprofile"
              }, 500);
            } else if (response.status == 'error') {
              toaster();
              toastr.error(response.message);
            }
          }

        });

         }
      //console.log(url);
    
     
  });
  </script>
