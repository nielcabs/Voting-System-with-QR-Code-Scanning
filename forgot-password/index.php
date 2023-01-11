<?php
    $url = "../";
    include_once($url.'connection/mysql_connect.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $myWebTitles; ?></title>
    <?php include_once($url.'head.php'); ?>
</head>

<body class="">
<div id="myloader" style="display:none;"></div>

<div id="">
    <div id="">
        <main>
            <div class="container">
                <form class="needs-validation" method="post" enctype="multipart/form-data" novalidate>
                <div id="reset_pass">
                    <div class="d-flex justify-content-center align-items-center vh-100" >
                        <div style="max-width: 400px;">
                            <div class="text-center">
                                <h5 class="mt-3 mb-2">Did you forgot your password?</h5>
                                <p>Enter your ID number and registered email address for your account below</p>
                            </div>
                            <div class="row gy-3">
                                <div class="col-sm-12">
                                    <label class="col-form-label col-form-label-md" for="username">ID Number</label>
                                    <input class="form-control form-control-md" type="text" id="username" size="150" required/>
                                    <div class="invalid-feedback">
                                        Enter ID No. / Username
                                    </div>
                                    <label class="col-form-label col-form-label-md" for="email_add">Registered Email Address</label>
                                    <input class="form-control form-control-md" type="text" id="email_add" size="150" required/>
                                    <div class="invalid-feedback">
                                        Enter a valid Email Address
                                    </div>
                                </div>
                                <div class="col-sm-12 d-flex flex-column align-items-center">
                                    <button id="btnForgot" type="button" value="Send" class="btn btn-maroon btn-md text-white w-100">
                                        <i class="fa fa-paper-plane mr-2" aria-hidden="true"></i> Send
                                    </button>
                                    <a href="../signin" class="mt-5 text-maroon">Back to Sign in</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="reset_msg">
                    <div class="row d-flex justify-content-center align-items-center vh-100" >
                        <div class="col-sm-4">
                            <div class="max-width: 400px;">
                                <div class="text-center">
                                    <div class="mx-auto" style="width: 8rem;">
                                        <img
                                            src="<?php echo $url; ?>img/email.png"
                                            alt=""
                                            class="img-fluid"
                                        />
                                    </div>
                                    <h2 class="mt-3 mb-2"> Reset your password </h2><br>
                                    <p>Check your email for your default password. If it doesn't appear within a few minutes, check your spam folder.</p>
                                </div>
                                <div class="text-center">
                                    <a href="../signin" class="mt-5 text-maroon">Return to sign in</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
</body>
</html>

<script>
    $('#reset_pass').show();
    $('#reset_msg').hide();

    function sendNewPass(newpass) {
        var username = $("#username").val();
        var email_add = $("#email_add").val();
        
        $.ajax({
            url :"email_newpass.php",
            method :"POST",
            data : {
                "username" : username,
                "email_add" : email_add,
                "newpass" : newpass
            },
            success:function(response) {
            
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                swal.fire({
                    title: "Oops...",
                    text: "Please check your internet connection and try again.",
                    type: "error",
                    confirmButtonColor: '#4e73df'
                })
            }
        });
    }

     function savePassword() {
        var username = $("#username").val();
        var email_add = $("#email_add").val();
   
        $('#btnVote').prop("disabled", true);

        $.ajax({
            type: "POST",
            url	: 'save.php',
            data:{
                "username" : username,
                "email_add" : email_add
            },
            success : function(response) {
                var myresponse = response.split('|');
                
                if ($.trim(myresponse[0]) === 'Success') {
                    $('#reset_pass').hide();
                    $('#reset_msg').show();
                    sendNewPass(myresponse[1])
                } else if ($.trim(myresponse[0]) === 'NotFound') { 
                    Swal.fire('Username or Email Address Not Found, Kindly Check.','', 'error') 
                } else {
                    Swal.fire('Error resetting your password.','', 'error') 
                    $('#btnVote').prop("disabled", false);  
                }
            },
                error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                swal.fire({
                    title: "Oops...",
                    text: "Please check your internet connection and try again.",
                    type: "error",
                    confirmButtonColor: '#4e73df'
                })
            }
        });
    }

    $(document).on("click", "#btnForgot", function(event) {
        var username = $("#username").val();
        var email_add = $("#email_add").val();
    
        event.preventDefault();
        if ($('.needs-validation')[0].checkValidity() === false) {
            event.stopPropagation();
        } else {
            setTimeout(function() {
                savePassword();
            }, 500)
        }
        $('.needs-validation').addClass('was-validated');
    });

</script>
