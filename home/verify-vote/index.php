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
                    Verify Vote
                </h4>
                
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="row mb-4">    
                            <div class="col-sm-3 mb-1">
                                <label for="verify_code" class="form-label-sm fw-bold">Ballot Receipt Code</label>
                                <input id="verify_code" type="text" class="form-control form-control-sm"  placeholder="Ballot Receipt Code">
                            </div>
                            
                            <div class="col-sm-3">
                               <br>
                                <button id="btnVerify" id="" type="button" class="btn btn-orange btn-sm px-4"><span id="save_label">Verify</span></button>
                            </div>
                        </div>  
                        <div id="tbl_voters_data"> </div>
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

    $('#btnVerify').click(function(){
        loadVerifyVote();
    });


    function loadVerifyVote(){
  
      $('#myloader').show();
      
      var verify_code   =  $('#verify_code').val(); 
    
      $.ajax({  
          url     :"tblVerifyVote.php",  
          method  :"POST",  
          data    :{
                      "verify_code"  : verify_code
                  },
          success:function(data){  
              $('#tbl_voters_data').html(data);
              $('#myloader').hide();
          }  
      });
      
    }
    loadVerifyVote();



</script>



<?php mysqli_close($db); ?>