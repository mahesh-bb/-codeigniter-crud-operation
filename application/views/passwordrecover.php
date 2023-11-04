 

  <main id="main">
    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">

   
         <!--  <h2>Contact</h2> -->
         <div class="section-header">
          <h2>Forget Password</h2>
        </div>

      <?php 
       // print_r($userid); die();
      ?>
        <div class="php-email-form p-3 p-md-4 form-size">
          <form id="pass_reco_form" method="POST" >
          <!--  -->
            <div class="form-group">
              <label>New Password</label>
              <input type="password" class="form-control" name="newpasswords" id="newpasswords" placeholder="Enter New Password" required>
              <span class="text-danger"><?= form_error('newpasswords'); ?></span>
            </div>
            <div class="form-group">
              <label>Confirm Password</label>
             <input type="password" class="form-control" name="confirmpasswords" id="confirmpasswords" placeholder="Enter Confirm password" required>
           
             <span class="text-danger"><?= form_error('confirmpasswords'); ?></span>
               <input type="hidden" value="<?= $userid ?>" name="userid" id="userid">
            </div>
           
            <div class="text-center"><button id="pass_reco" class="save-btn" class="" name="pass_reco">Recover</button></div>
          
          </form>
        </div>
        <!--End Contact Form -->

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->
  <script type="text/javascript">
    $("#pass_reco").click(function(event) {
 
      event.preventDefault();

      var validation_rec_pass = true;
      var newpasswords = $('#newpasswords').val();
      var confirmpasswords = $('#confirmpasswords').val();
      var userid = $('#userid').val();
      var url = base_url+'login/passwordrecover_process';

      if(newpasswords.length == ''){
         toaster();
          Command: toastr["error"]("Please Enter New Password");
          validation_rec_pass = false;
      }
      else if (newpasswords.length < 6) {
        toaster();
        Command: toastr["error"]('password minimum 6 character');
        validation_rec_pass = false;
      } else if (newpasswords.length > 12) {
        toaster();
        Command: toastr["error"]('password maximum 12 character');
        validation_rec_pass = false;
      } else if (newpasswords.search(/^(?=.*[a-z]).*$/) < 0) {
        toaster();
        Command: toastr["error"]('password must contain at least Lowercase Character.');
        validation_rec_pass = false;
      } else if (newpasswords.search(/[0-9]/) < 0) {
        toaster();
        Command: toastr["error"]('password must contain at least one Digit.');
        validation_rec_pass = false;
      } else if (newpasswords.search(/^(?=.*[A-Z]).*$/) < 0) {
        toaster();
        Command: toastr["error"]('password must contain at least Uppercase Character.');
        validation_rec_pass = false;
      } else if (!special_character.test(newpasswords)) {
        toaster();
        Command: toastr["error"]('Password must contain at least one Special Symbol.');
        validation_rec_pass = false;
      }

      else if(confirmpasswords.length == ''){
         toaster();
          Command: toastr["error"]("Please Enter confirm Password");
          validation_rec_pass = false;
      }

      else if(confirmpasswords != newpasswords){
         toaster();
          Command: toastr["error"]("Confirm Password not matched");
          validation_rec_pass = false;
      }

      if(validation_rec_pass ==  true){
          $.ajax({
          type: 'POST',
          url: url,
          data: {
            newpasswords: newpasswords,
            userid: userid
          },
          dataType: 'json',
          success: function(response) {
            if (response.status == 'success') {
              toaster();
              Command: toastr["success"](response.message);
              setTimeout(function() {
                window.location.href = base_url+"login"
              }, 500);
            } else if (response.status == 'error') {
              toaster();
              Command: toastr["error"](response.message);
            }
          }

        });
      }
});
  </script>
