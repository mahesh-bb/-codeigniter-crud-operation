


var regex_pattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
var special_character = /^(?=.*[~`!@#$%^&*()--+={}\[\]|\\:;"'<>,.?/_₹]).*$/;

function toaster() {

  toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "100",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }
  //   Command: toastr["error"]("All Feild Are Require")
}

// // function passwordvalidation(){
  
// // }

// // var myInput = document.getElementById("username");
// // var alphabate = document.getElementById("alphabate");
// // var digit = document.getElementById("number");

// // myInput.onfocus = function() {
// //   document.getElementById("message").style.display = "block";
// // }

// // // When the user clicks outside of the password field, hide the message box
// // myInput.onblur = function() {
// //   document.getElementById("message").style.display = "none";
// // }

// // myInput.onkeyup = function() {

// //   var alphabateLetters = /[a-z]/g;
// //   if (myInput.value.match(alphabateLetters)) {
// //     alphabate.classList.remove("invalid");
// //     alphabate.classList.add("valid");
// //   } else {
// //     alphabate.classList.remove("valid");
// //     alphabate.classList.add("invalid");
// //   }

// //   var numbers = /[0-9]/g;
// //   if (myInput.value.match(numbers)) {
// //     number.classList.remove("invalid");
// //     number.classList.add("valid");
// //   } else {
// //     number.classList.remove("valid");
// //     number.classList.add("invalid");
// //   }

// //   var dots = /[.]/g;
// //   if (myInput.value.match(dots)) {
// //     dot.classList.remove("invalid");
// //     dot.classList.add("valid");
// //   } else {
// //     dot.classList.remove("valid");
// //     dot.classList.add("invalid");
// //   }

// //   var uderscores = /[_]/g;
// //   if (myInput.value.match(uderscores)) {
// //     unsderscore.classList.remove("invalid");
// //     unsderscore.classList.add("valid");
// //   } else {
// //     unsderscore.classList.remove("valid");
// //     unsderscore.classList.add("invalid");
// //   }
// // }

//   });

function digitKeyOnly(e) {
    var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
    if ((keyCode >= 37 && keyCode <= 40) || (keyCode == 8 || keyCode == 9 || keyCode == 13) || (keyCode >= 48 && keyCode <= 57)) {
      return true;
    }
    return false;
} 

$("#basic-addon2").click(function(event) {
 
      event.preventDefault();
  var copyText = document.getElementById("copttotext");
  copyText.setSelectionRange(0, 99999);
  navigator.clipboard.writeText(copyText.value);
  
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "Copied:"
});

function outFunc() {
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "Copy to clipboard";
}