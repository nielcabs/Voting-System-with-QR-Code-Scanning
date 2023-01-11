<?php
    if (!isset($_SESSION)) { 
        session_start(); 
    } 

   ob_start();
    
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
        <form action="db-backup.php" method="post" id="db_backup">
            
            <main> 
                <div class="container">

                    <h4 class="mt-5 mb-4">
                        DATABASE BACK-UP
                    </h4>
                    
                    <div class="card border-0 shadow col-lg-6">
                        <div class="card-body"> 
                            
                        <div class="col-sm-12 mb-1">
                            <label for="server" class="form-label-sm fw-bold">Server Host</label>
                            <input name="server" id="server" type="text" class="form-control form-control-sm"  placeholder="Host" value="localhost" readonly>
                            <div class="invalid-feedback"> Please enter Server Host</div>
                        </div>

                        <div class="col-sm-12 mb-1">
                            <label for="username" class="form-label-sm fw-bold">User</label>
                            <input name="username" id="username" type="text" class="form-control form-control-sm"  placeholder="User" value="root" readonly>
                            <div class="invalid-feedback"> Please enter User</div>
                        </div>

                        <div class="col-sm-12 mb-1">
                            <label for="password" class="form-label-sm fw-bold">Password</label>
                            <input name="password" id="password" type="password" class="form-control form-control-sm"  placeholder="Password" value="" readonly>
                            <div class="invalid-feedback"> Please enter Password</div>
                        </div>

                        <div class="col-sm-12 mb-1">
                            <label for="dbname" class="form-label-sm fw-bold">Database Name</label>
                            <input name="dbname" id="text" type="text" class="form-control form-control-sm"  placeholder="Database" value="dhvsuevo_voting" readonly>
                            <div class="invalid-feedback"> Please enter Database</div>
                        </div>

                                
                            
                        </div>
                    </div>            

                    <button id="btnAddUsear"  type="submit" name="backupnow" class="btn btn-orange btn-xl my-5" ><span class="p-3"><i class="fa fa-plus">&nbsp;</i>Backup Database</span></button>
                </div>
            </main>  
        </form>   
        <?php include($url.'footer.php'); ?>   
    </div>
</div>


</body>
</html>

<script> 

    $("#db_backup").submit(function(e){
        
        e.preventDefault();
        var form = this;

        var server      = $('#server').val();
        var username    = $('#username').val();
        var password    = $('#password').val();
        var dbname      = $('#dbname').val();

        

            Swal.fire({
                title: 'DATABASE BACK-UP',
                text: "Are you sure you want to Back-Up Database?",
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
                    form.submit();
                    }, 1000)
                })
                }
            })
        
    });



</script>



<?php mysqli_close($db); ?>
