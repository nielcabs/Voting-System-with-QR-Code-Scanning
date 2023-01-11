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
<?php include_once($url."topbar.php"); ?>
<div id="layoutSidenav">
    <?php include_once($url."sidebar.php"); ?>
    <div id="layoutSidenav_content">
    
        <main> 
                <div class="container-fluid">  
                    <ol class="breadcrumb mt-3">
                        <h4 class="">
                            <i class="fa fa-dashboard">&nbsp; </i> Dashboard as of  <?php echo $monthName . ' ' . $day. ', '. $year; ?>
                        </h4>
                    </ol>
                            


                    <section class="content">
                        <div class="row">    

                            <!-- Col-1-->
                            <div class="col-lg-4">
                                <div class="small-box border-left-primary bg-white shadow">
                                    <div class="inner">
                                        <a class="fs-6 fw-bold text-primary mt-3 fs-u" href="fsl-availment">
                                           Voters
                                        </a>
                                        
                                        <h4 class="fw-bold text-gray-800">0</h4>
                                    </div>
                                    <div class="icon">
                                    <i class="fa-solid fa-car icon-dark fs-a"></i>
                                    </div>
                                    <!-- <div class="mt-5"></div> -->
                                    <a href="fsl-availment" class="small-box-footer text-primary mt-3">View <i class="fa fa-arrow-circle-right text-primary"></i></a>
                                </div>
                            </div>       
                
                           
                        </div>
                    </section>            
                </div>
           
        </main>     
        <?php include($url.'footer.php'); ?>   
    </div>
</div>
</body>
</html>

<!-- <script>

 $(document).ready(function(){ 
       $(document).bind("contextmenu",function(e){
              return false;
       }); 
    })

</script>

<script type="text/JavaScript"> 

    function killCopy(e){ return false } 
    function reEnable(){ return true } 
    
    document.onselectstart=new Function ("return false"); 
    if (window.sidebar) { 
        document.onmousedown=killCopy; 
        document.onclick=reEnable; 
    } 

</script>

<?php mysqli_close($db); ?> -->