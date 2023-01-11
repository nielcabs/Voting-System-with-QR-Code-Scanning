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
                    Add Department
                </h4>
                
                <div class="card border-0 shadow">
                    <div class="card-body"> 
                        <div id="tbl_voters_data"> </div>
                    </div>
                </div>            

                <button id="btnAddUser" type="button" class="btn btn-orange btn-xl my-5" data-bs-toggle="modal" data-bs-target="#viewUserModal"><span class="p-3"><i class="fa fa-plus">&nbsp;</i>Add Department</span></button>
            </div>
        </main>     
        <?php include($url.'footer.php'); ?>   
    </div>
</div>
<?php include('viewUserModal.php'); ?>


</body>
</html>

<script> 


    $(document).on("click", "#btnAddUser", function() {

        clearfields();
        $("#action").val('Add');
        $("#modal_title").html('Add');
        $("#save_label").html('Save');
        $("#rec_id").val(null);
    
        $("#viewUserModal").modal({
            backdrop: "static",
            keyboard: false
        });
    });	


    $(document).on("click", ".myModalUpdate", function() {

        var mydata      = $(this).data("update");
        var arr_data    = mydata.split("|");
        

        $("#rec_id").val(arr_data[0]);
        $("#dept_id").val(arr_data[1]);	
        $("#department").val(arr_data[2]);
        
        $("#action").val('Update');
        $("#modal_title").html('Update');
        $("#save_label").html('Update');
        $('#btnSave').prop("disabled", false);

        $("#viewUserModal").modal('show');

    });
    //----------End Update ----------//  


    function loadDepartment(){
  
      $('#myloader').show();

      var username_id   =  "<?php echo $username_id; ?>";
     
      $.ajax({  
          url     :"tblDepartment.php",  
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
    loadDepartment();


    //----------Begin Save ----------//                              
    function SaveDept(){

            var rec_id          = $("#rec_id").val();   
            var dept_id   = $("#dept_id").val();
            var department      = $("#department").val(); 
            var action          = $("#action").val();
        
            $('#btnSave').prop("disabled", true);

            $.ajax({
            type: "POST",
            url: 'save.php', 
            data: { "rec_id"            : rec_id,
                    "dept_id"           : dept_id,
                    "department"        : department,
                    "action"            : action
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
                        Swal.fire('Department ID '+ $.trim(myresponse[1]) +' already exist.','', 'error') 
                        $('#btnSave').prop("disabled", false);
                    } else if ($.trim(myresponse[0]) === 'Saved') {
                        Swal.fire('Successfully Saved.','', 'success')   
                        clearfields();
                        loadDepartment();
                    } else if ($.trim(myresponse[0]) === 'Updated') {
                        Swal.fire('Successfully Updated.','', 'success')   
                        loadDepartment();
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

            var election_id     = $("#election_id").val();
            var action          = $("#action").val();
        
            event.preventDefault();
            if ($('.needs-validation')[0].checkValidity() === false) {
                Swal.fire('Kindly fill out required fields.','', 'error')
                event.stopPropagation();
            } else {  

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
                        SaveDept();
                        
                        }, 1000)
                    })
                    }
                })
    
            } 
            $('.needs-validation').addClass('was-validated');
    });
    //----------End Save ----------//    


    function clearfields(){
    
        $("#dept_id").val(null);     
        $("#department").val(null); 
       
        $('.needs-validation').removeClass('was-validated');
        $('#btnSave').prop("disabled", false);  
    }

    $('#dept_id').on('input',function(){
        $("#dept_id").val( $(this).val().replace("'", "`"));
        $("#dept_id").val( $(this).val().toUpperCase());
    });
    $('#department').on('input',function(){
        $("#department").val( $(this).val().replace("'", "`"));
        // $("#department").val( $(this).val().toUpperCase());
    });
 

        //----------Begin Delete ----------//  
    function deletedata(rec_id) {
        $.ajax({  //START AJAX
                    
        type: 	"POST",
        url	:   'delete.php',
        data:{  "rec_id"             :   rec_id
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
                            loadDepartment();
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
   
    $(document).on("click", ".delete_dept", function() {
       
    
        var delete_id       = $(this).data("delete");
        var myarr_atc       = delete_id.split("|");

        var rec_id          = myarr_atc[0];
    

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
                    deletedata(rec_id);
                }, 500)
                })
            }
        })

    });



</script>



<?php mysqli_close($db); ?>
