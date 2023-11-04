
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
            <form id="edituserform" class="edituserform"  method="POST">
              
            <div class="col-lg-12 mt-2">
             <label>Mobile Mo</label>
             <input type="text" class="form-control" name="mobile" id="mobile" maxlength="10" value="<?= $user->mobile; ?>" placeholder="Enter Mobile Number"  onkeypress="return digitKeyOnly(event)"> 
              <span class="error"><?php echo form_error('mobile'); ?></span>
              
           </div>

           <div class="col-lg-12 mt-2">
             <label>Date Of Birth</label>
             <input type="text" class="form-control" name="dob" id="dob" value="<?= date('d-m-Y', strtotime($user->dob)); ?>" placeholder="" autocomplete="off"> 
              <span class="text-danger error"></span>
           </div>
      
          <div class="col-lg-12 mt-2">
             <label>Address</label>
             <textarea type="text" class="form-control" name="address" id="address" value="<?= $user->address; ?>" placeholder="Address"><?= $user->address; ?></textarea> 
              <span class="text-danger error"></span>
           </div>
           <div class="row">
             <div class="col-lg-4 mt-2">
             <label>City</label>
             <!-- <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" required> -->
             <select class="form-control" name="city" id="city">
               <option value="">Select City</option>
               <?php  foreach($cities as $city) { ?>
                <option value="<?= $city['city_id'] ?>" <?php if($city['city_id'] == $user->city_id ){ echo 'selected'; } ?>><?= $city['city']; ?></option>
              <?php } ?>
             </select> 
             <span id="city_error" class="errors" ><?php echo form_error('city'); ?></span> 
           </div>
          
           <div class="col-lg-4 mt-2">
             <label>State:</label>
             <select class="form-control" name="state" id="state">
               <option >Select State</option>
               <option value="<?= $user->state_id; ?>" <?php if(isset($user->city_id)){ echo 'selected'; }?>><?= $user->state; ?></option>
             </select> 
           </div>
           <div class="col-lg-4 mt-2">
             <label>Country:</label>
             <select class="form-control" name="country" id="country">
               <option >Select Country</option>
               <option value="<?= $user->country_id; ?>" <?php if(isset($user->state)){ echo 'selected'; }?>><?= $user->country; ?></option>
             </select>
           </div>
           </div>
      
         <div class="text-center">
           <button class="mt-2 save-btn update_user" id="updateuser" name="updateuser">Update</button>
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
    $('#dob').datepicker({
    weekStart: 1,
    autoclose: true,
    todayHighlight: true,
    orientation: 'bottom'
  }).keydown(false);
//$('#dobdate').datepicker("setDate", new Date()); <== it will be use to show current date in date picker textbox
    $('#city').select2();
$('#state').select2();
$('#country').select2();
    $('#city').on('change', function() {

  var city_id = $(this).val();
  //var base_url = $('#base_url').val();
  var url = base_url+'profile/StateGet';
  if (city) {
    $.ajax({
      url: url,
      type: "POST",
      data: {city_id:city_id},
      dataType: "json",
      success: function(data) {
        console.log(data);

        $('#state').empty();
          $('#state').append('<option value="' + data.state_id + '">' + data.state + '</option>');
        $('#country').empty();
          $('#country').append('<option value="' + data.country_id + '">' + data.country + '</option>');

      }
    });
  } else {
    $('#state').empty();
    $('#country').empty();
  }

});

$("#updateuser").click(function(event) {
      event.preventDefault();
      var validation_edituser_error = true;
      var mobile = $('#mobile').val();
      var dob = $('#dob').val();
      var address = $('#address').val();
      var city = $('#city').val();
      var state = $('#state').val();
      var country = $('#country').val();
    
      var url = base_url+'profile/userupdate';
      if (mobile.length == '') {
        toaster();
        Command: toastr["error"]('Please Enter Mobile No');
        validation_edituser_error = false;
      } else if (mobile.length != 10) {
        toaster();
        Command: toastr["error"]('Invalid Mobile No');
        validation_edituser_error = false;
      } else if (dob.length == '') {
        toaster();
        Command: toastr["error"]('Please Enter Date Of Birth');
        validation_edituser_error = false;
      }else if (city == '') {
        toaster();
        Command: toastr["error"]('Please Select City');
        validation_edituser_error = false;
      }

      if (validation_edituser_error == true) {
        //  console.log('ok');

          $.ajax({
          type: 'POST',
          url: url,
          data: {
            mobile: mobile,
            dob: dob,
            address: address,
            city: city,
            state: state,
            country: country
          },
          dataType: 'json',
          success: function(response) {
            if (response.status == 'success') {
              toaster();
              Command: toastr["success"](response.message);
              setTimeout(function() {
                window.location.href = base_url+"contact"
              }, 500);
            } else if (response.status == 'error') {
              toaster();
              Command: toastr["error"](response.message);
            }
          }

        });

         }
      //console.log(url);
  });
    </script>