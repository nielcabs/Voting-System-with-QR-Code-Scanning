<?php
    if (!isset($_SESSION)) { 
        session_start(); 
    } 
    
    $url                = "../../";
    $urlpic             = "../../";
    $addBack 	        = '../home/';
    include_once($url.'connection/mysql_connect.php');
    $username_id         = $_SESSION['username_id'];
    $access_rights       = $_SESSION['access_rights'];
    $fullname            = $_SESSION['fullname'];
    $department          = $_SESSION['department'];
    $chg_password        = $_SESSION['chg_password'];
 
    include_once($url.'connection/session.php');

    $monthName      = date('F', mktime(0, 0, 0, date('m'), 10));
    $day            = date('d');
    $year           = date('Y');
    $date_from      = date('m/d/Y'); 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $myWebTitles; ?></title>
    <?php include_once($url.'head.php'); ?>
    <style>
        #sidebar-nav {
            width: 445px;
        }
   </style>
</head>


<body class="sb-nav-fixed">
<div id="myloader" style="display:none;"></div>

<div id="layoutSidenav">
    <?php include_once("../../sidebar.php"); ?>

    <div id="layoutSidenav_content">
        <main> 
            <div class="container">  
                <h4 class="mt-5 mb-4">
                    Faculty Voter Accounts
                </h4>

                <div class="card border-0 shadow">
                    <div class="card-body"> 
                        <div id="tbl_voters_data"> </div>
                    </div>
                </div>            
                <div class="my-5">
                    <button id="btnAddUser" type="button" class="btn btn-orange" data-bs-toggle="modal" data-bs-target="#viewUserModal"><span class="p-3"><i class="fa fa-plus">&nbsp;</i>Add Voter</span></button>
                    <a id="btnUpload" href="upload-user-account.php" type="button" class="btn btn-red">Upload Voters</a>
                </div>
            </div>
        </main>     
        <?php include($url.'footer.php'); ?>   
    </div>
</div>
<?php include('viewUserModal.php'); ?>
</body>
</html>

<script> 
    //----------Begin Activate ----------// 
    $(document).on("click", ".act_deact", function() {
       
       var act_id          = $(this).data("active");
       var myarr_atc       = act_id.split("|");

       var rec_id          = myarr_atc[0];
       var username_id     = myarr_atc[1];
       var active          = myarr_atc[2];
        
       if(active =='Y'){
        var title_label = "Deactivate Voter";
       } else {
        var title_label = "Activate Voter";
       }

       Swal.fire({
           title: title_label,
           text: "Are you sure you want to continue?",
           type: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#4e73df',
           cancelButtonColor: '#858796',
           confirmButtonText: 'YES',
           cancelButtonText: 'NO',
           showLoaderOnConfirm: true,
           allowOutsideClick: false,
           preConfirm: function() {
               return new Promise(function(resolve) {
               setTimeout(function() {
                   resolve()
                   activate_deact(rec_id,username_id,active);
               }, 500)
               })
           }
       })

    });

    function activate_deact(rec_id,username_id,active) {
        $.ajax({  //START AJAX
                    
        type: 	"POST",
        url	:   'activate-deactivate.php',
        data:{  "rec_id"             :   rec_id,
                "username_id"        :   username_id,
                "active"             :   active
            },        
            success : function(response) {
                if($.trim(response)=="No record/s found."){
                    swal.fire({title: response,text: "",type: "error",confirmButtonColor: '#4e73df'})
                }else{ 
                
                    Swal.fire({
                        title: response,
                        text: "",
                        type: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#4e73df',
                        cancelButtonColor: '#858796',
                        confirmButtonText: 'OK',
                        allowOutsideClick: false
                    }).then((isConfirm) => {
                        if (isConfirm.value) {
                            loadVotersData();
                        }else{
                        }
                    }) 

                }
            },
                error: function(XMLHttpRequest, textStatus, errorThrown)
            {
            swal.fire({title: "Oops...",text: "Please check your internet connection and try again.",type: "error",confirmButtonColor: '#4e73df'})
            }
        });//endAjax

    }
    //----------End Activate ----------// 
    
    //----------Begin Delete ----------//  
    function deletedata(rec_id,username_id) {
        $.ajax({  //START AJAX
                    
        type: 	"POST",
        url	:   'delete.php',
        data:{  "rec_id"             :   rec_id,
                "username_id"        :   username_id
            },        
            success : function(response) {
                if($.trim(response)=="No record/s found."){
                    swal.fire({title: response,text: "",type: "error",confirmButtonColor: '#4e73df'})
                }else{ 
                
                    Swal.fire({
                        title: response,
                        text: "",
                        type: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#4e73df',
                        cancelButtonColor: '#858796',
                        confirmButtonText: 'OK',
                        allowOutsideClick: false
                    }).then((isConfirm) => {
                        if (isConfirm.value) {
                            loadVotersData();
                        }else{
                        }
                    }) 

                }
            },
                error: function(XMLHttpRequest, textStatus, errorThrown)
            {
            swal.fire({title: "Oops...",text: "Please check your internet connection and try again.",type: "error",confirmButtonColor: '#4e73df'})
            }
        });//endAjax

    }
   
    $(document).on("click", ".delete_user", function() {
       
    
        var delete_id       = $(this).data("delete");
        var myarr_atc       = delete_id.split("|");

        var rec_id          = myarr_atc[0];
        var username_id     = myarr_atc[1];
    

        Swal.fire({
            title: 'DELETE RECORD',
            text: "Are you sure you want to delete?",
            type: 'error',
            showCancelButton: true,
            confirmButtonColor: '#4e73df',
            cancelButtonColor: '#858796',
            confirmButtonText: 'YES',
            cancelButtonText: 'NO',
            showLoaderOnConfirm: true,
            allowOutsideClick: false,
            preConfirm: function() {
                return new Promise(function(resolve) {
                setTimeout(function() {
                    resolve()
                    deletedata(rec_id,username_id);
                }, 500)
                })
            }
        })

    });

    $(document).on("click", "#btnAddUser", function() {
        clearfields();
        $("#action").val('Add');
        $("#modal_title").html('Add');
        $("#rec_id").val(null);
        $('#user_password').attr('type', 'text');
        $("#user_password").prop("disabled", false); 
        $("#div_pass").hide();
        $("#div_row").show();
        $("#btnResetPass").hide();
        $("#viewUserModal").modal({
            backdrop: "static",
            keyboard: false
        });
    });	
    //----------End Delete ----------//  


    //----------Begin Update ----------//  
    $("#div_pass").hide();
    $("#div_row").hide();
    $(document).on("click", "#btnResetPass", function() {
        $("#div_pass").show();
        $("#div_row").hide();
    });

    // Pass Date to Update
    $("#btnResetPass").hide();
    $(document).on("click", ".myModalUpdate", function() {

        var mydata      = $(this).data("update");
        var arr_data    = mydata.split("|");
        

        $("#rec_id").val(arr_data[0]);
        $("#username_id").val(arr_data[1]);	
        $("#old_username_id").val(arr_data[1]);	
        $("#user_password").val(arr_data[2]);
        $("#first_name").val(arr_data[3]);
        $("#middle_name").val(arr_data[4]);	
        $("#last_name").val(arr_data[5]);
        $("#email").val(arr_data[6]);
        $("#department").val(arr_data[7]);
        
        $("#action").val('Update');
        $("#modal_title").html('Update');
        $("#new_password").val(null);
        $('#user_password').attr('type', 'password');
        $("#user_password").prop("disabled", true); 
        $('#btnSave').prop("disabled", false);
        $("#btnResetPass").show();
        $("#div_row").show();
        $("#div_pass").hide();
        $("#viewUserModal").modal('show');
    });
    //----------End Update ----------//  


    function loadVotersData(){
  
      $('#myloader').show();

      var username_id   =  "<?php echo $username_id; ?>";
     
      $.ajax({  
          url     :"tblVotersData.php",  
          method  :"POST",  
          data    :{
                      "username_id"  : username_id
                  },
          success:function(data){  
              $('#tbl_voters_data').html(data);
              $('#myloader').hide();
          }  
      });
      
    }
    loadVotersData();


    //----------Begin Save ----------//                              
    function SaveUsers(){

            var rec_id          = $("#rec_id").val();   
            var username_id     = $("#username_id").val(); 
            var old_username_id = $("#old_username_id").val();     
            var user_password   = $("#user_password").val(); 
            var first_name      = $("#first_name").val();  
            var middle_name     = $("#middle_name").val();  
            var last_name       = $("#last_name").val();  
            var email           = $("#email").val();  
            var department      = $("#department").val();   
            var action          = $("#action").val();
            var new_password    = $("#new_password").val();
        
            $('#btnSave').prop("disabled", true);

            $.ajax({
            type: "POST",
            url: 'save.php', 
            data: { "rec_id"            : rec_id,
                    "username_id"       : username_id,
                    "old_username_id"   : old_username_id,
                    "user_password"     : user_password,
                    "first_name"        : first_name,
                    "middle_name"       : middle_name,
                    "last_name"         : last_name,
                    "email"             : email,
                    "department"        : department,
                    "action"            : action,
                    "new_password"      : new_password
            },
                
                success: function(response) {

                    var myresponse = response.split('|');       
            
                    if ($.trim(myresponse[0]) == 'Relogin') { 
                        Swal.fire({
                                title: "Unable to save record, Your session has expired. Please re-login.",
                                text: "",
                                type: 'error',
                                showCancelButton: false,
                                confirmButtonColor: '#4e73df',
                                cancelButtonColor: '#858796',
                                confirmButtonText: 'OK',
                                cancelButtonText: 'NO',
                                allowOutsideClick: false
                        }).then((isConfirm) => {
                            if (isConfirm.value) {
                                location.reload();
                            }
                        })
                    } else if ($.trim(myresponse[0]) === 'exist') {
                        Swal.fire('Faculty ID Number: '+ $.trim(myresponse[1]) +' already exist.','', 'error') 
                        $('#btnSave').prop("disabled", false);
                    } else if ($.trim(myresponse[0]) === 'email_exist') {
                        Swal.fire('Email Address already exist.','', 'error') 
                        $('#btnSave').prop("disabled", false);
                    }else if ($.trim(myresponse[0]) === 'Saved') {
                        Swal.fire('Successfully Saved.','', 'success')   
                        clearfields();
                        loadVotersData();
                    } else if ($.trim(myresponse[0]) === 'Updated') {
                        Swal.fire('Successfully Updated.','', 'success')   
                        loadVotersData();
                    } else {
                        Swal.fire('Error Saving.','', 'error') 
                        $('#btnSave').prop("disabled", false);  
                    }

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    Swal.fire('Kindly check your internet connection.','', 'error') 
                }
            }); //AJAX-END	

    }

    $(document).on("click", "#btnSave", function(event) {

            var new_password    = $("#new_password").val();
            var action          = $("#action").val();
        
            event.preventDefault();
            if ($('.needs-validation')[0].checkValidity() === false) {
                Swal.fire('Kindly fill out required fields.','', 'error')
                event.stopPropagation();
            } else if (new_password =='' && action=='Update' && $('#div_pass').is(":visible")) {
                Swal.fire('Kindly fill out New Password.','', 'error')
                event.stopPropagation();
            }else {  

                Swal.fire({
                    title: 'Save Record?',
                    text: "Are you sure you want to save this record?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4e73df',
                    cancelButtonColor: '#858796',
                    confirmButtonText: 'YES',
                    cancelButtonText: 'NO',
                    showLoaderOnConfirm: true,
                    allowOutsideClick: false,
                    preConfirm: function() {
                    return new Promise(function(resolve) {
                        setTimeout(function() {
                        resolve()
                        SaveUsers();
                        
                        }, 1000)
                    })
                    }
                })
    
            } 
            $('.needs-validation').addClass('was-validated');
    });
    //----------End Save ----------//    

    function clearfields(){
    
        $("#username_id").val(null);     
        $("#user_password").val(null); 
        $("#first_name").val(null);  
        $("#middle_name").val(null);  
        $("#last_name").val(null);  
        $("#email").val(null);  
        $("#department").val(null);  
        $("#year").val(null);  
        $('.needs-validation').removeClass('was-validated');
        $('#btnSave').prop("disabled", false);  
    }


    //Uppercase & remove invalid char
    $('#first_name').on('input',function(){
        $("#first_name").val( $(this).val().replace("'", "`"));
        //$("#first_name").val( $(this).val().toUpperCase());
    });
    $('#middle_name').on('input',function(){
        $("#middle_name").val( $(this).val().replace("'", "`"));
       // $("#middle_name").val( $(this).val().toUpperCase());
    });
    $('#last_name').on('input',function(){
        $("#last_name").val( $(this).val().replace("'", "`"));
        //$("#last_name").val( $(this).val().toUpperCase());
    });

    $('#username_id').on('input',function(){
        var username_id =   $("#username_id").val();   
        var action          = $("#action").val();
        if(action =="Update") {

        } else {
            $("#user_password").val(username_id); 
        }
      
    });
 

</script>



<?php mysqli_close($db); ?> -->