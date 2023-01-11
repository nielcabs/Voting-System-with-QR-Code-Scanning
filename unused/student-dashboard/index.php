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
 
    if (!isset($_SESSION['E_Voting_System'])){
            header("Location:../");
    }

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

               
            </div>
        </main>     
        <?php include($url.'footer.php'); ?>   
    </div>
</div>
<?php include('viewUserModal.php'); ?>

<!-- The Modal -->
<div class="modal" data-bs-backdrop="static" data-bs-keyboard="false" id="viewSearch">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header bg-success">
        <h5 class="modal-title text-white fw-bold"><span id="modal_title"></span> Search Account</h5>
        <button id="closeModal1" type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">

        <div id="tbl_voters_search"> </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button id="closeModal2" id="" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>

    </div>
  </div>
</div>

</body>
</html>

<script> 

    $("#sc_local").hide();
    $('#election_name').change(function(){
        
        var election_name   = $("#election_name").val();
        var department      = $("#department").val();
        var date_started    = $("#date_started").val();
        var action          = $("#action").val();
      

        if (date_started == ''){
            Swal.fire('Please Select Date first.','', 'error') 
            $("#election_name").val(null);
        } else {

            if (election_name =="LDSC"){
                if (action =="Add"){
                    $("#sc_local").show();
                    $("#election_id").val(null);
                } else{
                    $("#sc_local").show();
                }
            } else {
                $("#sc_local").hide();
                electionID();
            }
        
        }

      
    });

    $('#department').change(function(){
        electionID();
    });

    function electionID(){
        var election_name   = $("#election_name").val();
        var department      = $("#department").val();
        var date_started    = $("#date_started").val();
        var uniqNo          = $("#uniqNo").val();
        var action          = $("#action").val();
        
        var arr_date        = date_started.split("/");
        var dmo             = arr_date[0];
        var day             = arr_date[1];
        var dyear           = arr_date[2];

        var date            = dmo+day+dyear;

        if (action =="Add"){
            if (election_name =="LDSC"){
                var election_id    = election_name+'-'+department+'-'+date+'-'+uniqNo;
                $("#election_id").val(election_id);
            } else {
                var election_id    = election_name+'-'+date+'-'+uniqNo;
                $("#election_id").val(election_id);
            }
        } else {

        }

    }

    $(document).on("click", "#btnAddUser", function() {

        clearfields();
        $("#action").val('Add');
        $("#modal_title").html('Add');
        $("#save_label").html('Save');
        $("#rec_id").val(null);
        $("#sc_local").hide();
     
        $("#viewUserModal").modal({
            backdrop: "static",
            keyboard: false
        });
    });	
    //----------End Delete ----------//  


    //----------Begin Update ----------// 

    // Pass Date to Update
    $("#btnResetPass").hide();
    $(document).on("click", ".myModalUpdate", function() {

        var mydata      = $(this).data("update");
        var arr_data    = mydata.split("|");
        

        $("#rec_id").val(arr_data[0]);
        $("#election_id").val(arr_data[1]);	
        $("#date_started").val(arr_data[2]);
        $("#election_name").val(arr_data[5]);
        $("#department").val(arr_data[6]);	
        
        $("#action").val('Update');
        $("#modal_title").html('Update');
        $("#save_label").html('Update');
        $('#btnSave').prop("disabled", false);

        $("#viewUserModal").modal('show');

    });
    //----------End Update ----------//  


    function loadElectionData(){
  
      $('#myloader').show();

      var username_id   =  "<?php echo $username_id; ?>";
     
      $.ajax({  
          url     :"tblElectionData.php",  
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
    loadElectionData();


    //----------Begin Save ----------//                              
    function SaveUsers(){

            var rec_id          = $("#rec_id").val();   
            var election_name   = $("#election_name").val();
            var election_id     = $("#election_id").val();
            var department      = $("#department").val();
            var date_started    = $("#date_started").val();  
            var action          = $("#action").val();
        
            $('#btnSave').prop("disabled", true);

            $.ajax({
            type: "POST",
            url: 'save.php', 
            data: { "rec_id"            : rec_id,
                    "election_name"     : election_name,
                    "election_id"       : election_id,
                    "department"        : department,
                    "date_started"      : date_started,
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
                        Swal.fire('Election ID '+ $.trim(myresponse[1]) +' already exist.','', 'error') 
                        $('#btnSave').prop("disabled", false);
                    } else if ($.trim(myresponse[0]) === 'Saved') {
                        Swal.fire('Successfully Saved.','', 'success')   
                        clearfields();
                        loadElectionData();
                    } else if ($.trim(myresponse[0]) === 'Updated') {
                        Swal.fire('Successfully Updated.','', 'success')   
                        loadElectionData();
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
            } else if (election_id=='' && $('#sc_local').is(":visible")) {
                Swal.fire('Election ID is Empty','', 'error')
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


    //----------Start Election ----------// 
    $(document).on("click", ".start", function() {
       
       var act_id          = $(this).data("start");
       var myarr_atc       = act_id.split("|");

       var rec_id          = myarr_atc[0];
       var election_id     = myarr_atc[1];
       var status          = myarr_atc[2];

       Swal.fire({
           title: "Start the Election",
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
                   start_election(rec_id,election_id,status);
               }, 500)
               })
           }
       })

    });

    function start_election(rec_id,election_id,status) {
        $.ajax({  //START AJAX
                    
        type: 	"POST",
        url	:   'start.php',
        data:{  "rec_id"             :   rec_id,
                "election_id"        :   election_id,
                "status"             :   status
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
                            loadElectionData();
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
    //----------End ----------// 



     //----------End Election ----------// 
     $(document).on("click", ".end", function() {
       
       var act_id          = $(this).data("end");
       var myarr_atc       = act_id.split("|");

       var rec_id          = myarr_atc[0];
       var election_id     = myarr_atc[1];
       var status          = myarr_atc[2];

       Swal.fire({
           title: "End the Election",
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
                   end_election(rec_id,election_id,status);
               }, 500)
               })
           }
       })

    });

    function end_election(rec_id,election_id,status) {
        $.ajax({  //START AJAX
                    
        type: 	"POST",
        url	:   'end.php',
        data:{  "rec_id"             :   rec_id,
                "election_id"        :   election_id,
                "status"             :   status
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
                            loadElectionData();
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
    //----------End ----------// 


    function clearfields(){
    
        $("#election_name").val(null);     
        $("#department").val(null); 
        $("#election_id").val(null);  
        $("#date_started").val(null);  
        $('.needs-validation').removeClass('was-validated');
        $('#btnSave').prop("disabled", false);  
    }


      //Date picker
    $(document).ready(function() {

        $('input[name="date_started"]').singleDatePicker();
        //Disable right click on specific input field
        $("#date_started").on("contextmenu",function(e){return false;});

        $("#clickdate").click(function(){
            $("#date_started").focus();
        });

    });
	$("#date_started").on("contextmenu",function(e){return false;}); 
	$.fn.singleDatePicker = function() {
		$(this).on("apply.daterangepicker", function(e, picker) {
			picker.element.val(picker.startDate.format(picker.locale.format));
			//setAge(picker.startDate);
		});
		return $(this).daterangepicker({
			singleDatePicker: true,
			showDropdowns: true,
			autoUpdateInput: false,
            autoApply: true
		});
	};
 

</script>



<?php mysqli_close($db); ?> -->