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
    <?php include_once($url."sidebar.php"); ?>
    <div id="layoutSidenav_content">
    
        <main> 
            <div class="container">  
                <h4 class="mt-5 mb-4">
                    Register Faculty Election Candidates
                </h4>

                <div class="card border-0 shadow">
                    <div class="card-body"> 
                        <div id="tbl_voters_data"> </div>
                    </div>
                </div> 

                <button id="btnAddUser" type="button" class="btn btn-orange my-5" data-bs-toggle="modal" data-bs-target="#viewUserModal"><span class="p-3"><i class="fa fa-plus">&nbsp;</i>Add Candidate</span></button>
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
   

    $(document).on("click", "#btnAddUser", function() {
        clearfields();
        $("#action").val('Add');
        $("#modal_title").html('Add');
        $("#save_label").html('Save');
        $("#rec_id").val(null);
        $("#party_name").html('<option value="" selected disabled>Select Party</option>');
        //disabled fields
        $("#student_id").prop("disabled", false); 
        $("#first_name").prop("disabled", false); 
        $("#middle_name").prop("disabled", false); 
        $("#last_name").prop("disabled", false);  
        $("#department").prop("disabled", false);
        //$("#year").prop("disabled", false);
        $("#position").prop("disabled", false); 
        $("#election_id").prop("disabled", false); 
        $("#party_name").prop("disabled", false);  
        $("#platform").prop("disabled", false);
        $("#upload_img").prop("disabled", false);
        $('#btnSave').prop("disabled", false);
        $('#btnSearch').prop("disabled", false);
        load_election_id()
        $("#viewUserModal").modal({
            backdrop: "static",
            keyboard: false
        });
    });	

    function load_election_id(election_id){
	
        var action    = $("#action").val();

        $('#myloader').show();
        if (action) {
            $.ajax({
                type: 'POST',
                url: 'load_election_id.php',
                data:   {
                            "action"        : action,
                            "election_id"   : election_id
                        },
                success: function(data) {
                    $('#election_id').html(data);
                    $('#myloader').hide();
                }
            });
        } else {
            $('#election_id').html('<option value="" selected disabled>Select Election</option>');
        }
	}  

    function load_party(election_id, party_name, student_id){
	
        var action      = $("#action").val();
        var position    = $("#position").val();
   
        $('#myloader').show();
        if (action) {
            $.ajax({
                type: 'POST',
                url: 'load_party.php',
                data:   {   
                            "election_id"   : election_id,
                            "party_name"    : party_name,
                            "action"        : action,
                            "position"      : position,
                            "student_id"    : student_id
                        },
                success: function(data) {
                    $('#party_name').html(data);
                    $('#myloader').hide();
                }
            });
        } else {
            $('#party_name').html('<option value="" selected disabled>Select Party</option>');
        }
	}  

    $(document).on("click", "#party_name", function() {
        
        var election_id      = $("#election_id").val();
        var position         = $("#position").val();

        if(election_id == null) {
            Swal.fire('Please select Election ID','', 'error') 
        }

    });	

    $('#election_id').change(function(){

        var election_id         = $("#election_id").val();
        var party_name          = $("#party_name").val();
        var position            = $("#position").val();
        
        if(position == null) {
            Swal.fire('Please select Position','', 'error') 
            $("#election_id").html('<option value="" selected disabled>Select Election</option>');
        } else {
            load_party(election_id, party_name)
        }
        
    });

    //----------Begin Update ----------//  

    $(document).on("click", ".myModalUpdate", function() {

        var mydata      = $(this).data("update");
        var arr_data    = mydata.split("|");

        $("#rec_id").val(arr_data[0]);
        $("#student_id").val(arr_data[1]);	
        $("#first_name").val(arr_data[2]);
        $("#middle_name").val(arr_data[3]);	
        $("#last_name").val(arr_data[4]);
        $("#department").val(arr_data[5]);
        //$("#year").val(arr_data[6]);
        $("#position").val(arr_data[7]);
       // $("#election_id").val(arr_data[8]);
        $("#platform").val(arr_data[9]);
        //$("#party_name").val(arr_data[10]);

        $("#upload_img").val(null); 
        $("#student_id").prop("disabled", true); 
        $("#first_name").prop("disabled", true); 
        $("#middle_name").prop("disabled", true); 
        $("#last_name").prop("disabled", true);  
        $("#department").prop("disabled", true);
        //$("#year").prop("disabled", true);

        
        if (arr_data[11] == 'Completed'){
            $("#position").prop("disabled", true); 
            $("#election_id").prop("disabled", true); 
            $("#party_name").prop("disabled", true);  
            $("#platform").prop("disabled", true);
            $("#upload_img").prop("disabled", true);
            $('#btnSave').prop("disabled", true);
            $('#btnSearch').prop("disabled", true);
        } else {
            $("#position").prop("disabled", false); 
            $("#election_id").prop("disabled", false); 
            $("#party_name").prop("disabled", false);  
            $("#platform").prop("disabled", false);
            $("#upload_img").prop("disabled", false);
            $('#btnSave').prop("disabled", false);
            $('#btnSearch').prop("disabled", false);
        }
        
        $("#action").val('Update');
        $("#modal_title").html('Update');
        $("#save_label").html('Update');
        //$('#btnSave').prop("disabled", false);
        load_election_id(arr_data[8])
        load_party(arr_data[8], arr_data[10], arr_data[1])
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

    function loadVotersData2(){
  
      $('#myloader').show();

      var username_id   =  "<?php echo $username_id; ?>";
     
      $.ajax({  
          url     :"tblSearch.php",  
          method  :"POST",  
          data    :{
                      "username_id"  : username_id
                  },
          success:function(data){  
              $('#tbl_voters_search').html(data);
              $('#myloader').hide();
          }  
      });
      
    }
    loadVotersData2();

    $(document).on("click", ".myModalUpdate2", function() {

        var mydata      = $(this).data("update");
        var arr_data    = mydata.split("|");
        

        //$("#rec_id").val(arr_data[0]);
        $("#student_id").val(arr_data[1]);	
        //$("#user_password").val(arr_data[2]);
        $("#first_name").val(arr_data[3]);
        $("#middle_name").val(arr_data[4]);	
        $("#last_name").val(arr_data[5]);
        // $("#email").val(arr_data[6]);
        $("#department").val(arr_data[7]);
        //$("#year").val(arr_data[8]);
        
       
        $("#modal_title").html('Add');
        $("#save_label").html('Save');
        $('#btnSave').prop("disabled", false);


        //disabled fields
        $("#student_id").prop("disabled", true); 
        $("#first_name").prop("disabled", true); 
        $("#middle_name").prop("disabled", true); 
        $("#last_name").prop("disabled", true); 
        $("#department").prop("disabled", true);
        //$("#year").prop("disabled", true);

        $("#viewSearch").modal('hide');
    });

    //----------Begin Save ----------//                              
    function SaveUsers(){

            var rec_id          = $(".rec_id").val();   
            var student_id      = $(".student_id").val();     
            var first_name      = $(".first_name").val();  
            var middle_name     = $(".middle_name").val();  
            var last_name       = $(".last_name").val();  
            var department      = $(".department").val();    
            //var year            = $(".year").val();  
            var position        = $(".position").val();  
            var party_name      = $(".party_name").val();  
            var election_id     = $(".election_id").val();  
            var platform        = $(".platform").val();  
            var action          = $(".action").val();
            var upload_img      = $(".upload_img").prop("files")[0];

            var form_data       = new FormData();

            form_data.append("rec_id",rec_id)    
            form_data.append("student_id",student_id)    
            form_data.append("first_name",first_name)    
            form_data.append("middle_name",middle_name)    
            form_data.append("last_name",last_name)    
            form_data.append("department",department)   
            form_data.append("position",position)    
            form_data.append("election_id",election_id)    
            form_data.append("platform",platform)    
            form_data.append("party_name",party_name)   
            form_data.append("action",action)    
            form_data.append("upload_img",upload_img)
        
            $('#btnSave').prop("disabled", true);

            $.ajax({
            type: "POST",
            url: 'save.php', 
            dataType: 'script',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
                
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
                    } else if ($.trim(myresponse[0]) === 'notexist') {
                        Swal.fire('Faculty ID No. not found!, Please register the voter first.','', 'error') 
                        $('#btnSave').prop("disabled", false);
                    } else if ($.trim(myresponse[0]) === 'exist') {
                        Swal.fire('Already registered as candidate  ','', 'error') 
                        $('#btnSave').prop("disabled", false);
                    } else if ($.trim(myresponse[0]) === 'Saved') {
                        Swal.fire('Successfully Saved.','', 'success')   
                        clearfields();
                        loadVotersData();
                        loadVotersData2();
                    } else if ($.trim(myresponse[0]) === 'Updated') {
                        Swal.fire('Successfully Updated.','', 'success')   
                        loadVotersData();
                        loadVotersData2();
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
    
        $("#student_id").val(null);    
        $("#first_name").val(null);  
        $("#middle_name").val(null);  
        $("#last_name").val(null);  
        $("#election_id").val(null); 
        $("#platform").val(null); 
        $("#party_name").val(null); 
        $("#department").val(null);  
       // $("#year").val(null);  
       $("#position").val(null);  
        $("#upload_img").val(null);  
        $('.needs-validation').removeClass('was-validated');
        $('#btnSave').prop("disabled", false);  
    }


    //Uppercase & remove invalid char
    $('#first_name').on('input',function(){
        $("#first_name").val( $(this).val().replace("'", "`"));
        $("#first_name").val( $(this).val().toUpperCase());
    });
    $('#middle_name').on('input',function(){
        $("#middle_name").val( $(this).val().replace("'", "`"));
        $("#middle_name").val( $(this).val().toUpperCase());
    });
    $('#last_name').on('input',function(){
        $("#last_name").val( $(this).val().replace("'", "`"));
        $("#last_name").val( $(this).val().toUpperCase());
    });

    $('#platform').on('input',function(){
        $("#platform").val( $(this).val().replace("'", "`"));
        //$("#platform").val( $(this).val().toUpperCase());
    });
 

</script>



<?php mysqli_close($db); ?>