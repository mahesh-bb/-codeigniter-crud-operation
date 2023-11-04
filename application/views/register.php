 <main id="main">
   <!-- ======= Contact Section ======= -->
   <section id="contact" class="contact">
     <div class="container" data-aos="fade-up">
       <div class="section-header page-title">
         <!--  <h2>Contact</h2> -->
         <p>
           <span>Registration</span>
         </p>
       </div>
       
       <div class="php-email-form p-3 p-md-4">
       <form id="formsave"  method="POST">
         <div class="row">
           <div class="col-lg-6">
             <label>Name:</label>
             <input type="text" class="form-control" name="username" id="username" placeholder="Enter User Name" autocomplete="off"> 
             
             <span id="username_error" class="errors" ><?php echo form_error('username'); ?></span>
             <div id="message">
                <span id="alphabate" class="invalid">at least Alphabate</span>, <span id="number" class="invalid">at least Digit</span>, 
                <span id="dot" class="invalid">at least dot</span>, <span id="unsderscore" class="invalid">at least underscore</span>
                <span id="username_error" class="errors" ><?php echo form_error('email'); ?></span>
             </div>
           </div>
           <div class="col-lg-6">
             <label>Email:</label>
             <input type="text" class="form-control" name="email" id="email" placeholder="Enter Email ID" > 
             <span id="email_error" class="errors" ><?php echo form_error('email'); ?></span>
             
           </div>
         </div>
         <div class="row mt-3">
           <div class="col-lg-6">
             <label>Mobile No.:</label>
             <input type="text" class="form-control" name="mobile" id="mobile" maxlength="10" placeholder="Enter Mobile Number" onkeypress="return digitKeyOnly(event)">
             <span id="mobile_error" class="errors" ><?php echo form_error('mobile'); ?></span>
            
           </div>
           <div class="col-lg-6">
             <label>Date Of Birth:</label>
             <input type="text" class="form-control" name="dob" id="dob" placeholder="DD-MM-YYYY" autocomplete="off" >
             <span id="dob_error" class="errors" ><?php echo form_error('dob'); ?></span>
            
           </div>
         </div>
         <div class="row mt-3">
           <div class="col-lg-6">
             <label>Password:</label>
             <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" >
             <span id="password_error" class="errors" ><?php echo form_error('password'); ?></span>
            
           </div>
            <div class="col-lg-6">
            <label>Address:</label>
           <textarea class="form-control" name="address" id="address" placeholder="Address" ></textarea> 
           </div> 
         </div>
         <div class="row mt-3">
           <div class="col-lg-4">
             <label>City:</label>
             <!-- <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" required> -->
             <select class="form-control" name="city" id="city">
               <option value="">Select City</option>
               <?php  foreach($cities as $city) { ?>
                <option value="<?= $city['city_id'] ?>"><?= $city['city']; ?></option>
              <?php } ?>
             </select> 
             <span id="city_error" class="errors" ><?php //echo form_error('city'); ?></span> 
           </div>
           <div class="col-lg-4">
             <label>State:</label>
             <select class="form-control" name="state" id="state">
               <option>Select State</option>
             </select> 
           </div>
           <div class="col-lg-4">
             <label>Country:</label>
             <select class="form-control" name="country" id="country">
               <option>Select Country</option>
             </select>
           </div>
         </div><input type="hidden" name="base_url" id="base_url" value="<?= base_url();?>">


         
         <div class="text-center">
           <button class="mt-2 save-btn " id="register"   name="register">Register</button>
           <!-- <input type="submit" id="register"name="register" > -->
         </div>
         <p>Are You Already Mamber <a href="<?= base_url() ?>login" class="url_link"><strong></strong><u>Login</u></strong></a></p>
       </form>
       </div>
       <!--End Contact Form -->
     </div>
   </section>
   <!-- End Contact Section -->
 </main>
 <!-- End #main -->

 <script type="text/javascript">
    $('#dob').datepicker({
    weekStart: 1,
    autoclose: true,
    todayHighlight: true,
    orientation: 'bottom'
  }).keydown(false);
//$('#dobdate').datepicker("setDate", new Date()); <== it will be use to show current date in date picker textbox


  // select city state and country
$('#city').select2();
$('#state').select2();
$('#country').select2();

$('#city').on('change', function() {

  var city_id = $(this).val();
  //var base_url = $('#base_url').val();
  var url = base_url+'UserDetails/getstate';
  if (city) {
    $.ajax({
      url: url,
      type: "POST",
      data: {city_id:city_id},
      dataType: "json",
      success: function(data) {
       // console.log(data.state);

        $('#state').empty();
        // $.each(data, function(key, value) {
        //   console.log('hello')
          $('#state').append('<option value="' + data.state_id + '">' + data.state + '</option>');
        // });

        $('#country').empty();
        // $.each(data, function(key, value) {
          $('#country').append('<option value="' + data.country_id + '">' + data.country + '</option>');
        // });
      }
    });
  } else {
    $('#state').empty();
    $('#country').empty();
  }

});


var regex_pattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
var special_character = /^(?=.*[~`!@#$%^&*()--+={}\[\]|\\:;"'<>,.?/_₹]).*$/;

// function passwordvalidation(){
  
// }

// var myInput = document.getElementById("username");
// var alphabate = document.getElementById("alphabate");
// var digit = document.getElementById("number");

// myInput.onfocus = function() {
//   document.getElementById("message").style.display = "block";
// }

// // When the user clicks outside of the password field, hide the message box
// myInput.onblur = function() {
//   document.getElementById("message").style.display = "none";
// }

// myInput.onkeyup = function() {

//   var alphabateLetters = /[a-z]/g;
//   if (myInput.value.match(alphabateLetters)) {
//     alphabate.classList.remove("invalid");
//     alphabate.classList.add("valid");
//   } else {
//     alphabate.classList.remove("valid");
//     alphabate.classList.add("invalid");
//   }

//   var numbers = /[0-9]/g;
//   if (myInput.value.match(numbers)) {
//     number.classList.remove("invalid");
//     number.classList.add("valid");
//   } else {
//     number.classList.remove("valid");
//     number.classList.add("invalid");
//   }

//   var dots = /[.]/g;
//   if (myInput.value.match(dots)) {
//     dot.classList.remove("invalid");
//     dot.classList.add("valid");
//   } else {
//     dot.classList.remove("valid");
//     dot.classList.add("invalid");
//   }

//   var uderscores = /[_]/g;
//   if (myInput.value.match(uderscores)) {
//     unsderscore.classList.remove("invalid");
//     unsderscore.classList.add("valid");
//   } else {
//     unsderscore.classList.remove("valid");
//     unsderscore.classList.add("invalid");
//   }
// }

$(document).ready(function() {
    $("#register").click(function(event) {
      event.preventDefault();
      var validation_error = true;
      var username = $('#username').val();
      var emailid = $('#email').val();
      var mobileno = $('#mobile').val();
      var dobdate = $('#dob').val();
      var password = $('#password').val();
      var address = $('#address').val();
      var cityname = $('#city').val();
      var state = $('#state').val();
      var country = $('#country').val();
      var url = base_url+'UserDetails/register_process';

      //console.log(url);
     // return false;

      if (username.length == '') {
        toaster();
        Command: toastr["error"]("Please Enter Name");
        validation_error = false;
      } else if (username.length < 8) {
        toaster();
        Command: toastr["error"]("Name Minimum 8 Character");
        validation_error = false;
      } else if (username.length > 12) {
        toaster();
        Command: toastr["error"]("Name maximum 12 Character");
        validation_error = false;
      } else if (!(/[a-z]/g).test(username)) {
        toaster();
        Command: toastr["error"]("Name in At Least alphabate Require");
        validation_error = false;
      } else if (!(/[0-9]/g).test(username)) {
        toaster();
        Command: toastr["error"]("Name in At Least Number Require");
        validation_error = false;
      } else if (!(/[.]/g).test(username)) {
        toaster();
        Command: toastr["error"]("Name in At Least dot Require");
        validation_error = false;
      } else if (!(/[_]/g).test(username)) {
        toaster();
        Command: toastr["error"]("Name in At Least unsderscore Require");
        validation_error = false;
      } else if (emailid.length == '') {
        toaster();
        Command: toastr["error"]('Please Enter Email');
        validation_error = false;
      } else if (!regex_pattern.test(emailid)) {
        toaster();
        Command: toastr["error"]('Invalid Email ID');
        validation_error = false;
      } else if (mobileno.length == '') {
        toaster();
        Command: toastr["error"]('Please Enter Mobile No');
        validation_error = false;
      } else if (mobileno.length != 10) {
        toaster();
        Command: toastr["error"]('Invalid Mobile No');
        validation_error = false;
      } else if (dobdate.length == '') {
        toaster();
        Command: toastr["error"]('Please Enter Date Of Birth');
        validation_error = false;
      } else if (password.length == '') {
        toaster();
        Command: toastr["error"]('Please Enter Password');
        validation_error = false;
      } else if (password.length < 6) {
        toaster();
        Command: toastr["error"]('password minimum 6 character');
        validation_error = false;
      } else if (password.length > 12) {
        toaster();
        Command: toastr["error"]('password maximum 12 character');
        validation_error = false;
      } else if (password.search(/^(?=.*[a-z]).*$/) < 0) {
        toaster();
        Command: toastr["error"]('password must contain at least Lowercase Character.');
        validation_error = false;
      } else if (password.search(/[0-9]/) < 0) {
        toaster();
        Command: toastr["error"]('password must contain at least one Digit.');
        validation_error = false;
      } else if (password.search(/^(?=.*[A-Z]).*$/) < 0) {
        toaster();
        Command: toastr["error"]('password must contain at least Uppercase Character.');
        validation_error = false;
      } else if (!special_character.test(password)) {
        toaster();
        Command: toastr["error"]('Password must contain at least one Special Symbol.');
        validation_error = false;
      } else if (cityname == '') {
        toaster();
        Command: toastr["error"]('Please Select City');
        validation_error = false;
      }

      if (validation_error == true) {
        $.ajax({
          type: 'POST',
          url: url,
          data: {
            username: username,
            email: emailid,
            mobile: mobileno,
            dob: dobdate,
            password: password,
            address: address,
            city: cityname,
            state: state,
            country: country
          },
          dataType: 'json',
          success: function(response) {
            if (response.status == 'success') {
              toaster();
              Command: toastr["success"](response.massege);
              setTimeout(function() {
                window.location.href = base_url+"verify-otp"
              }, 500);
            } else if (response.status == 'error') {
              toaster();
              Command: toastr["error"](response.massege);

            }else{
              window.location.href = base_url+"login"
            }
          }

        });
        return true;
      } else {
        return false;
      }
     
    });
  });


 </script>

 
