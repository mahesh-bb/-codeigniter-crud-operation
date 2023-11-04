<section id="contact" class="contact">
      <div class="container" data-aos="fade-up" style="margin-top: 35px;">

        <div class="section-header">
          <h2>Profile</h2>
        </div>

       

          <div class="col-md-4 display-card">
            <div class="info-item">
                   <a href="<?= base_url() ?>myprofile">Edit Profile</a>
            </div>
            <div class="info-item edit-profile">
                <a href="<?= base_url() ?>Profile/passwordupdate">Change Password</a>
            </div>
          </div><!-- End Info Item -->
          <div class="col-md-8 profile-edit-page">
            <div class="info-item">
                   <div class="php-email-form p-3 p-md-4 profile-edit-page-size">
            <form id="changepassword" class="changepassword"  method="POST">
         
           <div class="col-lg-10 mt-2">
             <label>Current Password:</label>
             <input type="password" class="form-control" name="oldpassword" id="oldpassword" placeholder="Enter Current Password" autocomplete="off"> <span class="text-danger"><?= form_error('oldpassword'); ?></span>
           </div>
           <div class="col-lg-10 mt-2">
             <label>New Password:</label>
             <input type="password" class="form-control" name="newpassword" id="newpassword" placeholder="Enter New Password" >
              <span class="text-danger"><?= form_error('newpassword'); ?></span>
           </div>
            <div class="col-lg-10 mt-2 " id="conf_pass">
             <label>Confirm Password:</label>
             <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Enter Confirm Password" > 
              <span class="text-danger"><?= form_error('confirmpassword'); ?></span>
           </div>
      
         <div class="text-center">
           <button class="mt-2 save-btn update_password" id="update_password" name="update_password">Update</button>
           <!-- <input type="submit" id="register"name="register" > -->
         </div>
         <!-- <p>Forget Password <a href="" class="url_link"><strong></strong><u>Click</u></strong></a></p> -->
       </form>
       </div>
            </div>
          </div><!-- End Info Item -->

       

        <!--End Contact Form -->

      </div>
    </section>
    <script type="text/javascript">
      $('#conf_pass').hide();
  $('#newpassword').keyup(function() {
    var x = document.getElementById('conf_pass');
    if($(this).val() == "") {
      x.style.display = 'none';
    } else {
      x.style.display = 'block';
    }
  });
  //confirm password text input hide/show end
  
$("#update_password").click(function(event) {
      event.preventDefault();

      var validation_upd_pass = true;
      var oldpassword = $('#oldpassword').val();
      var newpassword = $('#newpassword').val();
      var confirmpassword = $('#confirmpassword').val();
      var url = base_url+'profile/changepassword';

     // $("#confirmpassword").hide();
      if(oldpassword.length == ''){
         toaster();
          Command: toastr["error"]("Please Enter Old Password");
          validation_upd_pass = false;
      }
      else if (oldpassword.length < 6) {
        toaster();
        Command: toastr["error"]('password minimum 6 character');
        validation_error = false;
      } else if (oldpassword.length > 12) {
        toaster();
        Command: toastr["error"]('password maximum 12 character');
        validation_error = false;
      } else if (oldpassword.search(/^(?=.*[a-z]).*$/) < 0) {
        toaster();
        Command: toastr["error"]('password must contain at least Lowercase Character.');
        validation_error = false;
      } else if (oldpassword.search(/[0-9]/) < 0) {
        toaster();
        Command: toastr["error"]('password must contain at least one Digit.');
        validation_error = false;
      } else if (oldpassword.search(/^(?=.*[A-Z]).*$/) < 0) {
        toaster();
        Command: toastr["error"]('password must contain at least Uppercase Character.');
        validation_error = false;
      } else if (!special_character.test(oldpassword)) {
        toaster();
        Command: toastr["error"]('Password must contain at least one Special Symbol.');
        validation_error = false;
      }

      else if(newpassword.length == ''){
         toaster();
          Command: toastr["error"]("Please Enter New Password");
          validation_upd_pass = false;
      }
      else if (newpassword.length < 6) {
        toaster();
        Command: toastr["error"]('password minimum 6 character');
        validation_error = false;
      } else if (newpassword.length > 12) {
        toaster();
        Command: toastr["error"]('password maximum 12 character');
        validation_error = false;
      } else if (newpassword.search(/^(?=.*[a-z]).*$/) < 0) {
        toaster();
        Command: toastr["error"]('password must contain at least Lowercase Character.');
        validation_error = false;
      } else if (newpassword.search(/[0-9]/) < 0) {
        toaster();
        Command: toastr["error"]('password must contain at least one Digit.');
        validation_error = false;
      } else if (newpassword.search(/^(?=.*[A-Z]).*$/) < 0) {
        toaster();
        Command: toastr["error"]('password must contain at least Uppercase Character.');
        validation_error = false;
      } else if (!special_character.test(newpassword)) {
        toaster();
        Command: toastr["error"]('Password must contain at least one Special Symbol.');
        validation_error = false;
      }

      else if(confirmpassword.length == ''){
         toaster();
          Command: toastr["error"]("Please Enter confirm Password");
          validation_upd_pass = false;
      }

      else if(confirmpassword != newpassword){
         toaster();
          Command: toastr["error"]("Confirm Password not matched");
          validation_upd_pass = false;
      }

      if(validation_upd_pass ==  true){
          $.ajax({
          type: 'POST',
          url: url,
          data: {
            oldpassword: oldpassword,
            newpassword: newpassword
          },
          dataType: 'json',
          success: function(response) {
            if (response.status == 'success') {
              toaster();
              Command: toastr["success"](response.message);
              setTimeout(function() {
                window.location.href = base_url+"login"
              }, 500);
               $('#changepassword').reset();
            } else if (response.status == 'error') {
              toaster();
              Command: toastr["error"](response.message);
            }
          }

        });
      }
});
    </script>