<?php

  $url  = "../";

  include('../connection/mysql_connect.php');
 // include_once($url.'connection/session.php');

    if (!isset($_SESSION)) { 
        session_start(); 
    } 
    $access_rights = $_SESSION['access_rights'] ?? '';


    if ($access_rights =='std_admin' || $access_rights =='faculty_admin'){
            header("Location:../home");
    } else if ($access_rights =='std_voter'){
        header("Location:../student-dashboard");
    }else if ($access_rights =='faculty_voter'){
        header("Location:../faculty-dashboard");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Voting System</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css" />
  <link rel="stylesheet" href="../css/styles.css" />
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap"
    rel="stylesheet"
  />
  <link rel="icon" type="image/x-icon" href="<?php echo $url; ?>img/dhvsu-logo.png" />
  <?php include('../head.php'); ?>
</head>

<body>

  <!-- header -->

  <main class="login">
    <section class="login-form gradient-overlay" style="background: url('<?php echo $url; ?>img/maingate-dhvtsu.jpg') no-repeat center; background-size: cover;">
        <div class="container">
            <div class="content-wrapper d-flex justify-content-center align-items-center vh-100">
                <div class="card" style="width: 20rem;">
                    <div class="card-body p-4 text-black">
                        <form method="POST">
                            <div class="text-center mb-2">
                            <div class="mx-auto" style="margin-top: -5rem; width: 6rem;">
                                <img
                                src="<?php echo $url; ?>img/dhvsu-logo.png"
                                alt=""
                                class="img-fluid"
                                />
                            </div>
                            <h4 class="fw-bold mt-3 mb-1 text-uppercase">LOGIN</h4>
                            <p>Please login to your account</p>
                            </div>
                            <div class="form-outline">
                            <div style="display:none" class="alert alert-danger alert-dismissible fw-normal small py-1 text-center" id="error_msg"></div>
                            <label for="formGroupExampleInput" class="col-form-label form-label-md">ID Number</label>
                            <input type="text" id="username" class="form-control form-control-md" />
                            </div>
                            <div class="form-outline">
                            <label for="formGroupExampleInput2" class="col-form-label form-label-md">Password</label>
                            <input type="password" id="password" class="form-control form-control-md" />
                            </div>
                            <div class="mt-3 mb-3">
                            <button id="btn_login" class="btn btn-dark btn-md btn-block w-100" type="button">Login</button>
                            </div>
                            <a class="text-maroon" role="button" href="../forgot-password">Forgot password?</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
  </main>
  <?php include('myAlertBox.php'); ?>	
  <!-- footer -->

  <!-- build:js scripts -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="<?php echo $url; ?>js/functions.js"></script>
  <!-- endbuild -->

</body>

</html>

<script>

    function sendCode(username, email_add, code) {

        
        $.ajax({
            url :"email_code.php",
            method :"POST",
            data : {
                "username"  : username,
                "email_add" : email_add,
                "code"      : code
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

    $("#password").keypress(function(event) { 
        if (event.keyCode === 13) { 
            $("#btn_login").click(); 
        } 
    });
    
    $("#username").keypress(function(event) { 
        if (event.keyCode === 13) { 
            $("#btn_login").click(); 
        } 
    }); 

    $("#btn_login").click(function(){

        var username            = $.trim($("#username").val());
        var password            = $.trim($("#password").val());
   
        if (username == '' && password =='') {
            $("#error_msg").html("Please enter your username and password.").show();
        } else if (username == '') {
            $("#error_msg").html("Please enter your username.").show();
        } else if (password == '') {
            $("#error_msg").html("Please enter your password.").show();
        } else {
           
            $.ajax({

                type : "POST",
                url:'login.php', //URL to the delete php script
                data :  {   "username"          : username,
                            "password"          : password
                        },
                success : function(response) {
                        
                        $('#myloader').hide();
                        $("#error_msg").hide();
                        var strArray = response.split("|");	

                        if ($.trim(strArray[0])==='super_admin' && $.trim(strArray[1]) ==='Y') {
                            window.open("../home/", "_SELF");
                        } else if ($.trim(strArray[0])==='faculty_admin'  && $.trim(strArray[1]) ==='Y') {
                            window.open("../home/", "_SELF");
                        } else if ($.trim(strArray[0])==='std_admin' && $.trim(strArray[1]) ==='Y') {
                            window.open("../home/", "_SELF");
                        } else if ($.trim(strArray[0])==='std_voter' && $.trim(strArray[1]) ==='Y') {
                            window.open("../student-dashboard/", "_SELF");
                        } else if ($.trim(strArray[0])==='faculty_voter' && $.trim(strArray[1]) ==='Y') {
                            window.open("../faculty-dashboard/", "_SELF");
                        } else if ($.trim(strArray[0])==='ch_pass' && $.trim(strArray[1]) ==='Y') {
                            window.open("../change-password/", "_SELF");
                        } else if ($.trim(strArray[0])==='inactive') {
                            $("#error_msg").html('Your account is inactive due to not voting for 2 consecutive years. Please contact the administrator.').show();
                        } else if ($.trim(strArray[0])==='ch_pass_with_code') {
        
                            sendCode($.trim(strArray[2]), $.trim(strArray[3]), $.trim(strArray[4]))
                            setTimeout(function() {
                                window.open("../authentication/", "_SELF");
                            }, 1000)
                          
                        }else {
                            $("#error_msg").html($.trim(strArray[0])).show();
                           
                        }

                },//Success-END
                error: function(XMLHttpRequest, textStatus, errorThrown){
                        dispErr.style.display = "block";
                        $('#myloader').hide();
                       
                        $("#error_msg").html("Error: Please your internet connection and try again.");
                }
            });	//AJAX-END

        }
    });
</script>
<?php mysqli_close($db); ?>


