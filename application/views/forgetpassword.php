 

  <main id="main">
    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up" style="margin-top: 149px !important; ">

       <div class="section-header">
          <h2>Forget Password</h2>
        </div>

      
        <div class="php-email-form p-3 p-md-4 form-size">
          <form id="forgetpassword" method="POST" >
            <div class="form-group">
              <label>Email</label>
              <input type="text" class="form-control" name="email" id="email" placeholder="Enter Register Email" required>
              <span class="text-danger"><?= form_error('email'); ?></span>
            </div>
            <div class="text-center"><button id="forgetpassword_btn" class="save-btn" class="" name="forgetpassword_btn">Send</button></div>
          </form>
        </div>
       
      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->
  <script type="text/javascript">
    $("#forgetpassword_btn").click(function(event) {
      event.preventDefault();
      validation_forgetpass_error = true;
      var email = $('#email').val();
     
    
       var url = base_url+'login/forgetpass_process';
       if (email.length == '') {
          toaster();
          Command: toastr["error"]("Please Enter Email");
          validation_forgetpass_error = false;
        }
        else if (!regex_pattern.test(email)) {
          toaster();
          Command: toastr["error"]('Invalid Email ID');
          validation_error = false;
        }         
         if (validation_forgetpass_error == true) {
          //console.log('ok');

          $.ajax({
          type: 'POST',
          url: url,
          data: {
            email:email
          },
          dataType: 'json',
          success: function(response) {
            if (response.status == 'success') {
              // toaster();
              // Command: toastr["success"](response.message);
              // setTimeout(function() {
                window.location.href = base_url+"urllink"
              // }, 5000);
            } else if (response.status == 'error') {
              toaster();
              Command: toastr["error"](response.message);
            }
          }

        });

         }
  });
  </script>
