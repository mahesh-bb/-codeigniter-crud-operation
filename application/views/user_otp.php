<main id="main">
    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">
            <div class="section-header page-title">
                <!--  <h2>Contact</h2> -->
                <p><span>User Varification</span></p>
            </div>
            <div class="php-email-form p-3 p-md-4 form-size" style="margin-top: 75px; margin-bottom: 125px;">
              <form id="top_send_form" method="POST">
            
              <input type="hidden" name="base_url" id="base_url" value="<?= base_url();?>">
                <div class="form-group">
                    <input type="text" class="form-control" name="top" id="otp" placeholder="Enter Otp Number" maxlength="6" onkeypress="return digitKeyOnly(event)" required />
                </div>
                <input type="hidden" name="" id="user_id" value="<?= $this->session->userdata('user_id'); ?>">
                <div class="text-center"><button class="save-btn" id="otp_btn" name="otp_btn">Verify</button></div>
                <p class="mt-2" id="resend_otp_btn">Resend OTP <button class="resnd_otp_btn url_link" id="resend_otp" name="resend_otp"><u>Click here</u></button>
                  <div id="timer" class="timercouter"></div><div id="timercontain" class="validtimer" style="display: none;">Valid otp</div>
                </p>
            </form>
          </div>
            <!--End Contact Form -->
        </div>
    </section>
    <!-- End Contact Section -->
</main>
<!-- End #main -->

<script type="text/javascript">
   $(document).ready(function() {
      $("#otp_btn").click(function(event) {
       event.preventDefault();
          var validation_otp_error = true;
          var user_otp = $('#otp').val();
          var user_id = $('#user_id').val();
          var base_url = $('#base_url').val();
          var url = base_url+'UserDetails/verifyotp';
          
      
        if (user_otp.length == '') {
          toaster();
          Command: toastr["error"]("Please Enter OTP");
          validation_otp_error = false;
        }

        if ((user_otp.length != '') && (user_otp.length < 6) || (user_otp.length > 6)) {
          toaster();
          Command: toastr["error"]("Otp Must be contain 6 Digit");
          validation_otp_error = false;
        }

        if (validation_otp_error == true) {
        $.ajax({
          type: 'POST',
          url: url,
          data: {
            otp: user_otp,
            user_id: user_id
          },
          dataType: 'json',
          success: function(response) {
            if (response.status == 'success') {
              toaster();
              Command: toastr["success"](response.massege);
              setTimeout(function() {
                window.location.href = base_url+"login"
              }, 500);
            } else if (response.status == 'error') {
              toaster();
              Command: toastr["error"](response.massege);
            }
          }

        });
        return true;
      } else {
        return false;
      }
      
       });
  });
  
 

  $("#resend_otp").click(function(event) {
      event.preventDefault();
      //resendotptimer();
      var base_url = $('#base_url').val();
          var url = base_url+'UserDetails/otpresend';
    
      $.ajax({
          type: 'POST',
          url: url,
          dataType: 'json',
          success: function(response) {
            if (response.status == 'success') {

              toaster();
              Command: toastr["info"](response.massege);
              setTimeout(function() {
              }, 1000);
              resendotptimer();
            } else if (response.status == 'error') {
              toaster();
              Command: toastr["error"](response.massege);
            }
          }

        });
     
  });

   function resendotptimer(){
      document.getElementById("resend_otp_btn").style.display = "none";
      document.getElementById("timer").style.display = "block";
      document.getElementById("timercontain").style.display = "block";

      setTimeout(function(){  
      document.getElementById("timer").style.display="none"; 
      document.getElementById("timercontain").style.display = "none";          
      document.getElementById("resend_otp_btn").style.display="block"},60000);
      var timeoutHandle;
      function countdown(minutes, seconds) {
        function tick() {
            var counter = document.getElementById("timer");
            counter.innerHTML =
                minutes.toString() + ":" + (seconds < 10 ? "0" : "") + String(seconds);
            seconds--;
            if (seconds >= 0) {
                timeoutHandle = setTimeout(tick, 1000);
            } else {
                if (minutes >= 1) {
                    // countdown(mins-1);   never reach “00″ issue solved:Contributed by Victor Streithorst
                    setTimeout(function () {
                        countdown(minutes - 1, 59);
                    }, 1000);
                }
            }
        }
        tick();
    }

    countdown(0, 59);
}
</script>

