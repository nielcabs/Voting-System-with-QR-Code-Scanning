<?php
     if (!isset($_SESSION)) { 
        session_start(); 
    } 
    
    $url        = "../";
    $urlpic     = "../../";
    $addBack 	= '../home/';
    include_once($url.'connection/mysql_connect.php');
    $username_id         = $_SESSION['username_id'];
    $access_rights       = $_SESSION['access_rights'];
    $fullname            = $_SESSION['fullname'];
    $department          = $_SESSION['department'];
    $chg_password        = $_SESSION['chg_password'];
    $first_name          = $_SESSION['first_name'];
    $middle_name         = $_SESSION['middle_name'] ;
    $last_name           = $_SESSION['last_name'];
    $dept_id             = $_SESSION['dept_id'] ;
    $email               = $_SESSION['email'];
    $year_lvl            = $_SESSION['year_lvl'];
    if (!isset($_SESSION['E_Voting_System'])){
            header("Location:../");
    }

    $monthName      = date('F', mktime(0, 0, 0, date('m'), 10));
    $day            = date('d');
    $year           = date('Y');
    $date_from      = date('m/d/Y'); 
 

    $sql        = "SELECT * FROM tbl_department WHERE dept_id ='$dept_id'";
    $res        = mysqli_query($db, $sql);
    $row        = mysqli_fetch_assoc($res);
    $dept_name  = $row['department'] ?? '';


    $sql		= "SELECT first_name, middle_name, last_name, dept_id, year, email, profile_pic
                    FROM tbl_users
                    WHERE username_id ='$username_id'";	
    $res       = mysqli_query($db, $sql) or die (mysqli_error($db));
    $row       = mysqli_fetch_assoc($res);

    $first_name_a          = $row['first_name'] ?? '';
    $middle_name_a         = $row['middle_name'] ?? '';
    $last_name_a           = $row['last_name'] ?? '';
    $dept_id_a             = $row['dept_id'] ?? '';
    $email_a               = $row['email'] ?? '';
    $year_lvl_a            = $row['year'] ?? '';
    $profile_pic           = $row['profile_pic'] ?? '';

    $complete_name         = $first_name_a.' '.$middle_name_a.' '.$last_name_a;

    if($access_rights =="std_admin" || $access_rights =="std_voter" ) {
        $id_label ="Student ID: ";
    } else if($access_rights =="faculty_admin" || $access_rights =="faculty_voter" ) {
        $id_label ="Faculty ID: ";
    } else if($access_rights =="SUPERADMIN") {
        $id_label ="ID#: ";
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $myWebTitles; ?></title>
    <?php include_once($url.'head.php'); ?>
    <link href="<?php echo $url;?>bootstrap5/custom-css-js/jquery.passwordRequirements.css" rel="stylesheet">
</head>

<body class="sb-nav-fixed">
<div id="myloader" style="display:none;"></div>
<div id="layoutSidenav">
    <?php include_once($url."sidebar.php"); ?>
    <div id="layoutSidenav_content">
        <main class="mt-5">
            <div class="container-fluid">
                <div class="col-12 col-lg-4 d-flex flex-column h-100 mt-lg-0 mt-sm-2">
                    <div class="card">
                        <div class="card-body">
                            <h5>My Profile</h5>
                            <small class="text-muted"><?php echo $id_label.$username_id; ?></small>
                            <div class="text-center">
                                <div class="col-12 col-lg-auto p-3 candidate-page">
                                    <?php if($profile_pic !=''){?>
                                        <img width="150px" height="150px" class="avatar-image rounded-circle" src="<?php echo "../".$profile_pic; ?>" alt="Image">
                                    <?php } else {?>
                                        <img class="avatar-image rounded-circle" src="../profile_pic/default_pic.png" alt="Image" width="150px" height="150px">
                                    <?php }?>
                                </div>
                                <h6 class="mb-1"><?php echo $complete_name; ?></h6>
                            </div>
                            <div class="my-5">
                                <h5 class="mb-3">Profile Information</h5>
                                <ul class="list-unstyled">
                                    <li>
                                        <h6 class="mb-0">Last Name</h6>
                                        <p id="p_last_name"><?php echo $last_name_a; ?></p>
                                        <div id="i_last_name" class="col-sm-6">
                                            <input id="last_name" value="<?php echo $last_name_a; ?>" type="text" class="last_name form-control form-control-sm mb-2 mt-2 col-sm-4"  placeholder="Last Name">
                                            <input type="hidden" id="username_id" class="username_id" value="<?php echo $username_id; ?>">
                                        </div>
                                    </li>
                                    <li>
                                        <h6 class="mb-0">First Name</h6>
                                        <p id="p_first_name"><?php echo $first_name_a; ?></p>
                                        <div id="i_first_name" class="col-sm-6">
                                            <input id="first_name" value="<?php echo $first_name_a; ?>" type="text" class="first_name form-control form-control-sm mb-2 mt-2 col-sm-4"  placeholder="First Name">
                                        </div>
                                    </li>
                                    <li>
                                        <h6 class="mb-0">Middle Name</h6>
                                        <p id="p_middle_name"><?php echo $middle_name_a; ?></p>
                                        <div id="i_middle_name" class="col-sm-6">
                                            <input id="middle_name" value="<?php echo $middle_name_a; ?>" type="text" class="middle_name form-control form-control-sm mb-2 mt-2 col-sm-4"  placeholder="Middle Name">
                                        </div>
                                    </li>
                                    <!-- <li>
                                        <h6 class="mb-0">Email</h6>
                                        <p id="p_email"><?php //echo $email_a; ?></p>
                                        <div id="i_email" class="col-sm-6">
                                            <input id="email" value="<?php echo $email_a; ?>" type="text" class="email form-control form-control-sm mb-2 mt-2 col-sm-4"  placeholder="email">
                                        </div>
                                    </li> -->
                                    <!-- <li>
                                        <h6 class="mb-0">Department</h6>
                                        <p id="p_dept_name"><?php //echo $dept_name; ?></p>
                                        <div id="i_dept_name" class="col-sm-6">
                                            <select id="department" class="form-select form-select-sm department" required>
                                                <option value="" selected disabled>Select Department</option>
                                                    <?php
                                                        $get = "SELECT dept_id, department 
                                                                FROM tbl_department";
                                                        $res = mysqli_query($db, $get);

                                                        while ($row = mysqli_fetch_assoc($res)) {
                                                            if ($dept_id_a == $row['dept_id']) {
                                                                $xslctd = 'selected';
                                                            } else {
                                                                $xslctd = '';
                                                            }
                                                    ?>
                                                    <option value="<?php echo $row['dept_id']; ?>" <?php echo $xslctd; ?>> <?php echo $row['department']; ?> </option> 
                                                <?php  } ?>
                                            </select>
                                        </div>
                                    </li> -->
<!-- 
                                    <li>
                                        <h6 class="mb-0">Year</h6>
                                        <p id="p_year"><?php echo $year_lvl_a; ?></p>
                                        <div id="i_year" class="col-sm-6 mt-2 mb-2">
                                            <select id="year" class="form-select form-select-sm year" required>
                                                <option value="" selected disabled>Select Year</option>
                                                <option value="1" <?php if($year_lvl_a=="1"){ echo "selected";} ?>>1st Year</option>
                                                <option value="2" <?php if($year_lvl_a=="2"){ echo "selected";} ?>>2nd Year</option>
                                                <option value="3" <?php if($year_lvl_a=="3"){ echo "selected";} ?>>3rd Year</option>
                                                <option value="4" <?php if($year_lvl_a=="4"){ echo "selected";} ?>>4th Year</option>
                                                <option value="12" <?php if($year_lvl_a=="12"){ echo "selected";} ?>>Grade 12</option>
                                                <option value="11" <?php if($year_lvl_a=="11"){ echo "selected";} ?>>Grade 11</option>
                                            </select>
                                        </div>
                                    </li>       -->
                                    <li>
                                        <div id="up_image" class="col-sm-6 mt-2">
                                            <h6 class="mb-2">Upload Image</h6>
                                            <input class="form-control form-control-sm upload_img mb-2" type="file" id="upload_img" name="upload_img" value="">
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="position-relative btn-holder mt-auto">
                                <button id="btnEdit" type="button" class="btn btn-orange btn-md w-100 mt-3">Edit profile</button>
                                <button id="btnSave" type="button" class="btn btn-orange btn-md w-100 mt-3">Save</button>
                                <button id="btnCancel" type="button" class="btn btn-red btn-md w-100 mt-3">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include($url.'footer.php'); ?>
    </div>
</div>
</body>
</html>

<script>

    $(document).on("click", "#btnSave", function(event) {

        Swal.fire({
            title: 'Save Record?',
            text: "Are you sure you want to update your profile?",
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
                
                }, 500)
            })
            }
        })
    
    });

    //----------Begin Save ----------//                              
    function SaveUsers(){
  
        var username_id     = $(".username_id").val();     
        var first_name      = $(".first_name").val();  
        var middle_name     = $(".middle_name").val();  
        var last_name       = $(".last_name").val();  
        var department      = $(".department").val(); 
        var email           = $(".email").val(); 
        var upload_img      = $(".upload_img").prop("files")[0];

        var form_data       = new FormData();

        form_data.append("username_id",username_id)      
        form_data.append("first_name",first_name)    
        form_data.append("middle_name",middle_name)    
        form_data.append("last_name",last_name)    
        form_data.append("department",department)    
        form_data.append("email",email)    
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
                    Swal.fire('Student No. not found!, Please register the voter first.','', 'error') 
                    $('#btnSave').prop("disabled", false);
                } else if ($.trim(myresponse[0]) === 'Saved') {
                    Swal.fire({
                            title: "You have successfully save your profile.",
                            text: "",
                            type: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#4e73df',
                            cancelButtonColor: '#858796',
                            confirmButtonText: 'OK',
                            cancelButtonText: 'NO',
                            allowOutsideClick: false
                    }).then((isConfirm) => {
                        if (isConfirm.value) {

                            setTimeout(function() {
                           
                                location.reload();
                            }, 100)
                         
                        }
                    })
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
    
    $(document).on("click", "#btnEdit", function() {
       ShowEditProfile()
    });	

    $(document).on("click", "#btnCancel", function() {
        CancelEdit()
    });	

    function ShowEditProfile(){

        $("#p_last_name").hide(); 
        $("#p_first_name").hide();  
        $("#p_middle_name").hide();
        $("#p_email").hide();
        $("#p_dept_name").hide();
        $("#p_year").hide();

        $("#i_last_name").show(); 
        $("#i_first_name").show();  
        $("#i_middle_name").show();
        $("#i_email").show();
        $("#i_dept_name").show();
        $("#i_year").show();
        $("#up_image").show();


        $("#btnEdit").hide();
        $("#btnSave").show(); 
        $("#btnCancel").show(); 

    }

    function CancelEdit(){

        $("#p_last_name").show(); 
        $("#p_first_name").show();  
        $("#p_middle_name").show();
        $("#p_email").show();
        $("#p_dept_name").show();
        $("#p_year").show();

        $("#i_last_name").hide(); 
        $("#i_first_name").hide();  
        $("#i_middle_name").hide();
        $("#i_email").hide();
        $("#i_dept_name").hide();
        $("#i_year").hide();
        $("#up_image").hide();


        $("#btnEdit").show();
        $("#btnSave").hide(); 
        $("#btnCancel").hide(); 


    }

    function hideInputFields(){

        $("#i_last_name").hide(); 
        $("#i_first_name").hide();  
        $("#i_middle_name").hide();
        $("#i_email").hide();
        $("#i_dept_name").hide();
        $("#i_year").hide();
        $("#up_image").hide();

        $("#btnSave").hide(); 
        $("#btnCancel").hide(); 
    }

    hideInputFields()


</script>

<?php mysqli_close($db); ?>
