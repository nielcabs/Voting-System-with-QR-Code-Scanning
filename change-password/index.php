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
 
    if (!isset($_SESSION['E_Voting_System'])){
            header("Location:../");
    }

    $monthName      = date('F', mktime(0, 0, 0, date('m'), 10));
    $day            = date('d');
    $year           = date('Y');
    $date_from      = date('m/d/Y'); 
 

    if($access_rights =='std_admin') {
        $active_users   = "AND access_rights IN ('std_admin','std_voter')";
        $active_users2  = "AND access_rights IN ('std_voter')";
        $active_users3  = "WHERE left(election_id,3) ='USC' OR left(election_id,4) ='LDSC'";

    } else if($access_rights =='faculty_admin') {
        $active_users = "AND access_rights IN ('faculty_admin','faculty_voter')";
        $active_users2 = "AND access_rights IN ('faculty_voter')";
        $active_users3  = "WHERE left(election_id,3) ='FCE'";
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
<input type="hidden" id="usr_name" name="usr_name" value="<?php echo $username_id; ?>">
<input type="hidden" id="access_rights" name="usr_name" value="<?php echo $access_rights; ?>">
<div id="layoutSidenav">
    <?php include_once($url."sidebar.php"); ?>

    <div id="layoutSidenav_content">
        <main class="mt-5">
            <div class="container-fluid">
                <!-- <h1>Dashboard</h1> -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="">
                            <div class="">
                                </div>
                                <!-- /.box-header -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mr-2 ml-2 mb-1">
                                        <h4>Change Password</h4>
                                        <label class="col-form-label col-form-label-sm" for="old_pass">Current Password</label>
                                        <input type="password" class="form-control form-control-user" id="old_pass" value="" maxlength="20" required>
                                        <div class="invalid-feedback">
                                        Current Password is required
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-1">
                                        <label class="col-form-label col-form-label-sm" for="new_pass">New Password</label>
                                        <input type="password" class="pr-password form-control form-control-user" id="new_pass" value="" maxlength="20" required>
                                        <div class="invalid-feedback">
                                            <p>Passwords should include the following character types:</p>
                                            <p style="display:none" id="upperCaseLetters"><i class="fa-solid fa-xmark"></i>&nbsp;Uppercase letters: A-Z</p>
                                            <p style="display:none" id="lowerCaseLetters"><i class="fa-solid fa-xmark"></i>&nbsp;Lowercase letters: a-z</p>
                                            <p style="display:none" id="onenumber"><i class="fa-solid fa-xmark"></i>&nbsp;Number [0-9]</p>
                                            <p style="display:none" id="onespecialchar"><i class="fa-solid fa-xmark"></i>&nbsp;Symbols: !@#$^&*</p>
                                            <p style="display:none" id="pwdlimitnumbers"><i class="fa-solid fa-xmark"></i>&nbsp;Minimum 8 characters and numbers</p>
                                            <p style="display:none" id="shortpass">Short passwords are easy to guess. Try one with at least 8 characters.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-1">
                                        <label class="col-form-label col-form-label-sm" for="confirm_pass">Confirm New Password</label>
                                        <input type="password" class="form-control form-control-user" id="confirm_pass" value="" maxlength="20" required>
                                        <div class="invalid-feedback">
                                            <p style="display:none" id="pwdNOTmatch">These passwords don't match. Try again?</p>
                                        </div>
                                    </div>
                                </div>   
                            </div>
                                    <!-- END CHAT BOX DIV -->
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="float-right">
                                    <?php if($chg_password  == "Y"){ } else{?>
                                    <a href=""> <button class="btn btn-orange" type="button">Cancel</button></a>
                                    <?php }?>
                                    <button class="btn btn-orange" type="button" id="cmdsave">Save</button>
                                </div>
                            </div>
                            <!-- /.box-footer-->
                        </div>
                    </div><div class="col-md-6"></div>
                </div>
            </div>
        </main>   

        <?php include($url.'footer.php'); ?>  
    </div>

</div>
</body>
</html>
<script src="../bootstrap5/js/jquery.passwordRequirements.min.js"></script>
<script>

    function CheckPassword(inputtxt) { 
        var lowerCaseLetters    = /[a-z]/g;
        var upperCaseLetters    = /[A-Z]/g;
        var onespecialchar      = /[!@#$%^&*)]/g;
        var numbers             = /[0-9]/g;
        var pwdvalcount = 5;
        
        $("#upperCaseLetters").show();
        $("#lowerCaseLetters").show();
        $("#pwdlimitnumbers").show();
        $("#onespecialchar").show();
        $("#onenumber").show();
        
        if(inputtxt.match(upperCaseLetters)) {
            $("#upperCaseLetters").hide();
            pwdvalcount--;
        }
        
        if(inputtxt.match(lowerCaseLetters)) {;
            $("#lowerCaseLetters").hide();
            pwdvalcount--;
        }
        
        if(inputtxt.match(onespecialchar)) {;
            $("#onespecialchar").hide();
            pwdvalcount--;
        }
        
        if(inputtxt.match(numbers)) {;
            $("#onenumber").hide();
            pwdvalcount--;
        }
        
        if(inputtxt.length >= 8) {
            $("#pwdlimitnumbers").hide();
            pwdvalcount--;
        }

        if (pwdvalcount > 0){
            $("#new_pass").removeClass("is-valid");
            $("#new_pass").addClass("is-invalid");
            return false;
        } else {
            $("#new_pass").removeClass("is-invalid");
            $("#new_pass").addClass("is-valid");
            return true;
        }
        
        
    }

    $(document).on("change", "#confirm_pass", function() {

        var pwdcheck    = $("#new_pass").val()
        var pwdconcheck = $("#confirm_pass").val()

        if (pwdcheck === pwdconcheck) {
            $("#pwdNOTmatch").hide();
            $("#new_pass").removeClass("is-invalid");
            $("#confirm_pass").removeClass("is-invalid");
        } else {
            $("#pwdNOTmatch").show();
            $("#confirm_pass").addClass("is-invalid");
        }

    });

    // $(document).on("change", "#new_pass", function() {

    //     var pwdcheck = $("#new_pass").val()

    //     if (pwdcheck.length < 8) {
    //         $("#shortpass").show();
    //         $("#new_pass").removeClass("is-valid");
    //         $("#new_pass").addClass("is-invalid");
    //     } else {
    //         $("#shortpass").hide();
    //         $("#new_pass").removeClass("is-invalid");
    //     }

    // });

    $(document).on("input", "#new_pass", function() {
        $("#new_pass").val( $(this).val().replace("'", ""));
        $("#new_pass").val( $(this).val().replace('"', ""));
        CheckPassword($(this).val());
    });

    $(document).on("keyup", "#new_pass", function() {

        $("#confirm_pass").val(null);
        $("#pwdNOTmatch").hide();
        $("#confirm_pass").removeClass("is-invalid");

    });
    
    $(document).on("keyup", "#new_pass", function() {

        $("#confirm_pass").val(null);
        $("#pwdNOTmatch").hide();
        $("#confirm_pass").removeClass("is-invalid");

    });
    
    $("#cmdsave").click(function(){

        $('#myloader').show();
        var usrname    =   $("#usr_name").val();
        var oldPwd     =   $("#old_pass").val(); 
        var newPwd     =   $("#new_pass").val();
        var conNewPwd  =   $("#confirm_pass").val(); 
        var access_rights  =   $("#access_rights").val(); 

        if (usrname === '' || oldPwd === '' || newPwd === '' || conNewPwd === ''){
            $('#myloader').hide();
            swal.fire('Please fill out required fields.','','error');
            $("#usr_name").removeClass("is-valid");
            $("#usr_name").addClass("is-invalid");
            $("#old_pass").removeClass("is-valid");
            $("#old_pass").addClass("is-invalid");
            $("#new_pass").removeClass("is-valid");
            $("#new_pass").addClass("is-invalid");
            $("#confirm_pass").removeClass("is-valid");
            $("#confirm_pass").addClass("is-invalid");
        } else if (newPwd.length < 8) {
            $('#myloader').hide();
            swal.fire('Short passwords are easy to guess. Try one with at least 8 characters.','','error');
            $("#confirm_pass").removeClass("is-valid");
            $("#confirm_pass").addClass("is-invalid");
            $("#new_pass").removeClass("is-valid");
            $("#new_pass").addClass("is-invalid");
        } else if (newPwd === '12345678') {
            $('#myloader').hide();
            swal.fire('Oops!','This is a default password, please try a new one.','','error')
            $("#confirm_pass").removeClass("is-valid");
            $("#confirm_pass").addClass("is-invalid");
            $("#new_pass").removeClass("is-valid");
            $("#new_pass").addClass("is-invalid");
        } else if (newPwd != conNewPwd) {
            $('#myloader').hide();
            swal.fire('The Passwords you typed do not matched. Please retype the new password.','','error')
            $("#confirm_pass").removeClass("is-valid");
            $("#confirm_pass").addClass("is-invalid");
            $("#new_pass").removeClass("is-valid");
            $("#new_pass").addClass("is-invalid");
        } else {
            $("#confirm_pass").removeClass("is-invalid");
            $("#new_pass").removeClass("is-invalid");
            $("#old_pass").removeClass("is-invalid");
            //AJAX
            $.ajax({

                type : "POST",
                url:'changepassword_validation.php',
                data :{    "user_name":usrname,
                           "old_pass":oldPwd,
                           "new_pass":newPwd,
                           "confirm_pass":conNewPwd
                           },
                success : function(response) {
                 $('#myloader').hide();
                    if($.trim(response)=="You have entered an Invalid Password" || 
                       $.trim(response)=="The Passwords you typed do not matched. Please retype the new password." ||
                       $.trim(response)=="Please fill out the fields!"){
                         swal.fire(response,'','error')
                    } else {

                        Swal.fire({
                            title: response,
                            text: "Information",
                            type: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#4e73df',
                            cancelButtonColor: '#858796',
                            confirmButtonText: 'OK',
                            allowOutsideClick: false
                        }).then((isConfirm) => {
                            if (isConfirm.value) {
                                if (access_rights =='std_voter') {
                                    window.open ("../student-dashboard/", "_self");
                                } else if(access_rights =='faculty_voter') {
                                    window.open ("../faculty-dashboard/", "_self");
                                } else if(access_rights =='std_admin' || access_rights =='faculty_admin') {
                                    window.open ("../home/", "_self");
                                }
                               
                            } else {
                            }
                        }) 

                    }
                },
                     error: function(XMLHttpRequest, textStatus, errorThrown)
                {
                    $('#myloader').hide();
                    swal.fire('Oops...','The Passwords you typed do not matched. Please retype the new password.','','error')
                }

            });
            /////AJAX END
        }
    });
</script>

<?php mysqli_close($db); ?>
