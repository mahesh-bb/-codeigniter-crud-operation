<style type="text/css">
  .swal2-modal .swal2-icon, .swal2-modal .swal2-success-ring {
    margin-bottom: 2px !important;
}
</style>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Manage User</h4>
            <form id="exceldownload">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Select Status</label>
                    <select class="form-control" name="userstatus" id="userstatus">
                      <option value="all" selected="">All</option>
                      <option value="1">Active</option>
                      <option value="2">Block</option>
                      <option value="0">Deactive</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Date Range</label>
                    <input class="form-control" name="daterange" id="daterange" value="<?php echo date('d-m-Y',strtotime('-1month')); ?> to <?php echo date('d-m-Y');?>"  placeholder="dd/mm/yyyy"/>
                  </div>
                </div>
                <div class="col-md-6" style="margin-top: 30px;">
                  <button name="userlist_btn" id="userlist_btn" class="btn btn-primary">Filter</button>
                  <button name="export" id="export_excel" class="btn btn-warning">Export</button>
                  <button name="export" id="export_pdf" class="btn btn-info">PDF</button>
                  <input type="file" name="import" class="" id="import_excel" />
                  <!-- <button name="import" id="import_excel" class="btn btn-secondry">Import</button> -->
                  <!-- <button name="export" id="export_excel" onclick="DownloadFile('Sample.xlsx')" class="btn btn-warning">Export</button> -->
                </div>
              </div>
              </form>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">User List</h4>
            <?php //print_r($userstatus['status']); die(); ?>

               <table id="usermanage" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>DOB</th>
                            <th>City</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
                <!-- User Details Edit by Admin -->
                <div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel" style="margin-left: -442px; margin-right: 376px;">Edit User</h4>
                            </div>
                            <div class="modal-body">
                                <div class="insertHere">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" id="userupdate" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
              </div>

                 <!-- User Password Edit by Admin -->
                <div class="modal fade" id="password_chnage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel" style="margin-left: -442px; margin-right: 258px;">Change User Password</h4>
                            </div>
                            <div class="modal-body">
                                <div class="password_html"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" id="changepassword" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
       
      </div>
    </div>
  </div>

<script type="text/javascript">
   

$('#myModal').on('shown.bs.modal', function(e) {
    flatpickr("#dob", {
         dateFormat: "d-m-Y",
    });
});
flatpickr("#daterange", {
  mode: "range",
  dateFormat: "d-m-Y",
  maxDate: "today",
  defaultDate: ["<?php echo date('d-m-Y',strtotime('-1month')); ?>", "<?php echo date('d-m-Y');?>"],
});
    var userstatus = $('#userstatus').val();
    var daterange = $('#daterange').val();
    var table;
    fill_datatable(userstatus,daterange);

    function fill_datatable(userstatus, daterange){
      console.log('hello');
      var table = $('#usermanage').DataTable({
        
        searching: true,
        "ajax" : {
            url:base_url+"showuserlist",
            type:"POST",
            data:{userstatus:userstatus,daterange:daterange},
             "dataSrc": function (json) { 
                return json.data;  
              },  
        },

        'language' : {
            "zeroRecords": "No data available in table"             
        },
        
        'columns': [
            {"data":"name"},
            {"data":"email"},
            {"data":"mobile"},
            {"data":"dob"},
            {"data":"city"},
            {"data":"status",
              "render": function ( data, type, row ) {
               
                var rec='';
                var st= row.status == 1 ? 'Active' : row.status == 0 ? 'Deactive' : 'Block';
                var stclass= (row.status == 1) ? 'success' :'danger';
                var tongle = (row.status == 1) ? 'success' :'danger';
                
                var deactive = 0; 
                var active = 1;
                var block = 2;

                rec+='<div class="btn-group">';
                rec+='<button type="button" id="myButton" class="btn btn-'+stclass+'">'+st+'</button>';
                rec+='<button type="button" class="btn btn-'+tongle+' dropdown-toggle dropdown-toggle-split" data-id="" id="dropdownMenuSplitButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="sr-only">Toggle Dropdown</span></button>'
                rec+='<div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton3">';
                if(row.status != "0")
                {
                rec+='<button id="statusdeactive" data-status="'+deactive+'" data-user_id="'+row.id+'" class="dropdown-item status_uses">Deactive</button>';
                }
                if(row.status != "1")
                {
                rec+='<button id="statusactive" data-status="'+active+'" data-user_id="'+row.id+'" class="dropdown-item status_uses">Active</button>';
                }
                if(row.status != "2")
                {
                rec+='<button id="statusblock" data-status="'+block+'"class="dropdown-item status_uses" data-user_id="'+row.id+'">Block</button>';
                }
                rec+='</div>';
                return rec;

              },
            },
            {
              "data": "id",                   
              "render": function ( data, type, row ) {
                var button = "";
                  button += '<button class="btn btn-primary bckuseredit" data-user_id="'+row.id+'"id="bckuseredit" onclick="editmodelopen('+row.id+')"data-bs-toggle="modal" data-bs-target="#bckuseredit" >Edit</button> ';
                  button += '<button class="btn btn-info bckupassupd" data-user_id="'+row.id+'" id="bckupassupd" data-bs-toggle="modal" data-bs-target="#bckupassupd">Password Update</button> '; 
                  button += '<button class="btn btn-danger" data-user_id="'+row.id+'" name="remove_user" id="remove_user">Delete</button>';
                  return button;
                },
            }
        ],

        'columnDefs': [ 
          {
            'targets': [6], // column index (start from 0)
            'orderable': false, // set orderable false for selected columns
          },
          {"className": "dt-center", "targets": "_all"}
        ]

        }); //data table end
        
         $(document).on('click', '#remove_user', function(event){
          event.preventDefault();
          var userid = $(this).attr("data-user_id");
          var $button = $(this);
          var url = base_url+"userdelete";
          Swal.fire({
              title: 'Are you sure?',
              text: "User Record Delete!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
          if (result.isConfirmed) {
              $.ajax({
              type: 'POST',
              url: url,
              data: {
                userid: userid
              },
              dataType: 'json',
              success: function(response) {
                if (response.status == 'success') {
                  Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                  )
                  table.row($button.parents('tr')).remove().draw();
                 //window.location.reload();
                }
              }
            });
          }
        });

      });

     
    }

    $(document).on('click', '.bckupassupd', function() {
      
      var userid = $(this).attr("data-user_id");
      var url = base_url+"userpassword";
      var inhtml ='';
      $('#password_chnage').modal('show');
           $.ajax({
              type: 'POST',
              url: url,
              data: {
                userid: userid
              },
            dataType: 'json',
            success: function( ) {
             // console.log();
              inhtml += '<div class="form-group">';
              inhtml += '<lable>Your Password</lable>';
              inhtml += '<input type="password" class="form-control" id="admin_password" name="admin_password" placeholder="Enter Your Password">';
              inhtml += '</div>';
              inhtml += '<div class="form-group">';
              inhtml += '<lable>User Password</lable>';
              inhtml += '<input type="password" class="form-control" id="user_password" name="user_password" placeholder="Enter User Password">';
              inhtml += '</div>';
              inhtml += '<input type="hidden" name="hidename" id="hidename" value="'+res.id+'">';
              $('.password_html').html(inhtml);
            }
        });
    });

 
  //  $(document).on('click', '.bckuseredit', function() {
            function editmodelopen(userid)
            {
              var url = base_url+"editmodal";
              var html ='';
              $('#myModal').modal('show'); 
               $.ajax({
                type: 'POST',
                url: url,
                data: {
                  userid: userid
                },
              dataType: 'json',
              success: function(res) {
                console.log('hello');
                  html+='<div class="form-group">';
                  html+='<lable>Username</lable>';
                  html+='<input type="text" class="form-control" id="uname" name="unmae" value="'+res.name+'">';
                  html+='</div>';
                  html+='<div class="form-group">';
                  html+='<lable>Email</lable>';
                  html+='<input type="text" class="form-control" id="uemail" name="uemail" value="'+res.email+'">';
                  html+='</div>';
                  html+='<div class="form-group">';
                  html+='<lable>Mobile</lable>';
                  html+='<input type="text" class="form-control" id="umobile" name="umobile" maxlength="10" value="'+res.mobile+'" onkeypress="return digitKeyOnly(event)">';
                  html+='</div>';
                  html+='<div class="form-group">';
                  html+='<lable>Date Of Birth</lable>';
                  html+='<input type="text" value="'+res.dob+'" class="form-control date-input" name="dob"  id="dob" placeholder="DD-MM-YYYY" autocomplete="off" >'
                  html+='</div>';
                  html+='<input type="hidden" name="hidename" id="hidename" value="'+res.id+'">';
                  html+='</div>';
                  $('.insertHere').html(html);
              }
          });
            }
            
  
    $('#userlist_btn').click(function(event){ 
        event.preventDefault();
        clear_data();
    });
      function clear_data()
        {
          var userstatus = $('#userstatus').val();
          var daterange = $('#daterange').val();
          $('#usermanage').DataTable().destroy();
          fill_datatable(userstatus, daterange);
        }


       

     $('#userupdate').click(function(event){ 
        event.preventDefault();

        var data_error = true;
        var uname = $('#uname').val();
        var uemail = $('#uemail').val();
        var umobile = $('#umobile').val();
        var udob = $('#dob').val();
        var hidename = $('#hidename').val();
        var url = base_url+"backuseredit";

       if (uname.length == '') {
        toastr.error("Please Enter Name");
        data_error = false;
        } else if (uname.length < 8) {
          toastr.error("Name Minimum 8 Character");
          data_error = false;
        } else if (uname.length > 12) {
          toastr.error("Name maximum 12 Character");
          data_error = false;
        } else if (!(/[a-z]/g).test(uname)) {
          toastr.error("Name in At Least alphabate Require");
          data_error = false;
        } else if (!(/[0-9]/g).test(uname)) {
          toastr.error("Name in At Least Number Require");
          data_error = false;
        } else if (!(/[.]/g).test(uname)) {
          toastr.error("Name in At Least dot Require");
          data_error = false;
        } else if (!(/[_]/g).test(uname)) {
          toastr.error("Name in At Least unsderscore Require");
          data_error = false;
        } else if (uemail.length == '') {
          toastr.error('Please Enter Email');
          data_error = false;
        } else if (!regex_pattern.test(uemail)) {
          toastr.error('Invalid Email ID');
          data_error = false;
        } else if(umobile.length == '') {
          toastr.error('Please Enter Mobile No');
          data_error = false;
        } else if (umobile.length != 10) {
          toastr.error('Invalid Mobile No');
          data_error = false;
        } else if (udob.length == '') {
          toastr.error('Please Enter Date Of Birth');
          data_error = false;
        } 

        if(data_error == true)
        {
            $.ajax({
            type: 'POST',
            url: url,
            data: {
              uname: uname,
              uemail: uemail,
              umobile: umobile,
              udob: udob,
              hidename: hidename
            },
            dataType: 'json',
            success: function(response) {
             if (response.status == 'success') {
              $('#myModal').modal('hide');
              toastr.success(response.message);
              setTimeout(function() {
                clear_data();
              }, 500);
            } else if (response.status == 'error') {
              toastr.error(response.message);
            }
            }
          });
        }
      });


        $('#changepassword').click(function(event){ 
          event.preventDefault();
          var pass_error = true;
          var adminpassword = $('#admin_password').val();
          var userpassword = $('#user_password').val();
          var hidename = $('#hidename').val();
          var url = base_url+"backpassupd";
       
          if(adminpassword.length == '')
          {
            toastr.error('Please Your Enter Password');
            pass_error = false;
          }
          else if (userpassword.length == '') 
          {
            toastr.error('Please User Enter Password');
            pass_error = false;
          } else if (userpassword.length < 6) {
            toastr.error('User password minimum 6 character');
            pass_error = false;
          } else if (userpassword.length > 12) {
            toastr.error('User password maximum 12 character');
            pass_error = false;
          } else if (userpassword.search(/^(?=.*[a-z]).*$/) < 0) {
            toastr.error('User password must contain at least Lowercase Character.');
            pass_error = false;
          } else if (userpassword.search(/[0-9]/) < 0) {
            toastr.error('User password must contain at least one Digit.');
            pass_error = false;
          } else if (userpassword.search(/^(?=.*[A-Z]).*$/) < 0) {
            toastr.error('User password must contain at least Uppercase Character.');
            pass_error = false;
          } else if (!special_character.test(userpassword)) {
            toastr.error('User Password must contain at least one Special Symbol.');
            pass_error = false;
          }

          if(pass_error == true)
          {
              $.ajax({
              type: 'POST',
              url: url,
              data: {
                admin_password: adminpassword,
                user_password: userpassword,
                hidename: hidename
              },
              dataType: 'json',
              success: function(response) {
                if (response.status == 'success') {
                  $('#password_chnage').modal('hide');
                  toastr.success(response.message);
                  setTimeout(function() {
                    clear_data();
                  }, 500);
                } else if (response.status == 'error') {
                  toastr.error(response.message);
                }
              }
            });
          }
      });
        
        $(document).on('click', '.status_uses', function(event){
          event.preventDefault();

          var url = base_url+"userstatus";
          var status_active = $(this).attr("data-status");
          var userid = $(this).attr("data-user_id");
          
           $.ajax({
              type: 'POST',
              url: url,
              data: {
                statususer: status_active,
                userid: userid
              },
              dataType: 'json',
              success: function(response) {
                if (response.status == 'success') {
                  toastr.success(response.message);
                  clear_data();
                } else if (response.status == 'error') {
                  toastr.error(response.message);
                }
              }
            });
        });

         $(document).on('click', '#export_excel', function(event){
          event.preventDefault();
          //console.log('hell0');
         // var excelval = $(this).val();
          var dt = new Date();
          var userstatus = $('#userstatus').val();
          var daterange = $('#daterange').val();
          var url = base_url+"exportexcel";
         
          // if()
          // {

          // }
          
          $.ajax({
              type: 'POST',
              url: url,
              data: {userstatus:userstatus,daterange:daterange},
              dataType: 'json'
              }).done(function(data){
              
                if(data.status == 'error')
                {
                  toastr.error(data.message);
                }else{
                  var $a = $("<a>");
                  $a.attr("href",data.file);
                  $("body").append($a);
                  $a.attr("download","Usersheet"+dt.getTime()+".xlsx");
                  $a[0].click();
                  $a.remove();
                }
                  

              });
        });


         $(document).on('click', '#export_pdf', function(event){
          event.preventDefault();
          //console.log('hell0');
         // var excelval = $(this).val();
          var dt = new Date();
          var userstatus = $('#userstatus').val();
          var daterange = $('#daterange').val();
          var url = base_url+"generatepdf";
         
          // if()
          // {

          // }
          
          $.ajax({
              type: 'POST',
              url: url,
              data: {userstatus:userstatus,daterange:daterange},
              dataType: 'json'
              }).done(function(data){
              
                if(data.status == 'error')
                {
                  toastr.error(data.message);
                }else{
                  var $a = $("<a>");
                  $a.attr("href",data.file);
                  $("body").append($a);
                  $a.attr("download","userinfo"+dt.getTime()+".pdf");
                  $a[0].click();
                  $a.remove();
                }
                  

              });
        });

        //    $(document).on('click', '#import_excel', function(event){
        //    event.preventDefault();

          
        // });

           
              $('#import_excel').change(function(){  
                   $('#exceldownload').submit();  
              });  
              $('#exceldownload').on('submit', function(event){  
                   event.preventDefault();  
                   var url = base_url+"importexcel";
                   
                   $.ajax({  
                        url:url,  
                        method:"POST",  
                        data:new FormData(this),  
                        contentType:false, 
                        dataType: 'json', 
                        processData:false,  
                        success:function(response){
                        if (response.status == 'success') {
                          toastr.success(response.message);
                        } else {
                          toastr.error(response.message);
                        }
                        }  
                   });  
              });  
            
  </script>

