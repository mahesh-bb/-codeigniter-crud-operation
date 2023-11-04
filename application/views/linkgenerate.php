 <?php date_default_timezone_set('Asia/Kolkata'); ?>
 <style type="text/css">
 .tooltips
 {
   position: relative;
  display: inline-block;
 }
 .tooltips .tooltiptext {
  visibility: hidden;
  width: 140px;
  background-color: #555;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px;
  position: absolute;
  z-index: 1;
  bottom: 150%;
  left: 50%;
  margin-left: -75px;
  opacity: 0;
  transition: opacity 0.3s;
}
.tooltips .tooltiptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}

.tooltips:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
}
 </style>
  <main id="main">
   <!-- ======= Contact Section ======= -->
   <section id="contact" class="contact">
     <div class="container" data-aos="fade-up" style="margin-top: 149px !important; ">
       <div class="section-header">
         <h2>Forget Password Link generate</h2>
       </div> 

        <div class="php-email-form p-3 p-md-4 forget-pass">
         <form id="" style="">
           <div class="input-group mb-3 w-50">
             <input type="text" value="<?php  echo $url; ?>" class="form-control" id="copttotext" disabled>
             <div class="input-group-append tooltips">
               <button class="input-group-text" id="basic-addon2" style="height: 48px;
                margin-left: -3px;" onmouseout="outFunc()"><span class="tooltiptext" id="myTooltip">Copy to Clipborad</span>Copy url</button>
             </div>
           </div>
         </form>
       </div>
     </div>
   </section>
   <!-- End Contact Section -->
 </main>
 <!-- End #main -->