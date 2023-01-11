<?php

    $url = "../";
    session_start();
    include('../connection/mysql_connect.php');

    // if (isset($_SESSION['LTMS_CISSD_SYSTEM'])){
    //     header("Location:../");
    // }

?>
<html>
<head>
    <title><? echo $myWebTitles; ?></title>
    <?php include('../head.php'); ?>
</head>
<body class="bg-light">
<?php include('header.php'); ?>
<div id="myloader" style="display:none;"></div>
<div style="background-color:#008eca; height:35px;" class="fixed-top-2"></div><br><br>
    <div class="container-fluid">
    <form method="POST">
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col">
                <div class="card">
                    <div class="card-header bg-primary  text-white">Login to your account</div>
                    <div class="card-body">
                       
                        <div style="display:none" class="alert alert-danger alert-dismissible" id="error_msg"></div>
                        <label class="col-form-label col-form-label" for="new_pass">Username</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Username" required="">

                        <span class="glyphicon glyphicon-user form-control-feedback text-primary"></span>

                        <label class="col-form-label col-form-label" for="confirm_pass">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required=""> 

                       

                        <div class="d-grid gap-3 py-3">
                            <button type="button" class="btn btn-primary btn-sm btn-block" id="btn_login"> Login </button>
                        </div>
                    </div> 
                    
                   
                       
                    
                </div>
            </div>
            <div class="col-sm-4"></div>
        </div>
    </form>    
    <p class="text-muted text-center">&copy; <?php echo date("Y");?> E-Voting System.</p>
    <a href=""><p class="text-center mt-1 text-blue">Forgot Password?</p></a>
    <?php include('myAlertBox.php'); ?>	
        
    </div>

</body>
</html>

<script>

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

                        if ($.trim(strArray[0])==='super_admin') {
                            window.open("../home/", "_SELF");
                        } else if ($.trim(strArray[0])==='student_voter') {
                            window.open("../home/e-voting", "_SELF");
                        }else{
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