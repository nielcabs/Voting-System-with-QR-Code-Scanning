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
 
 
    include_once($url.'connection/session.php');

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

    } else if($access_rights =='SUPERADMIN') {
        $active_users = "AND access_rights IN ('faculty_admin','faculty_voter', 'std_admin','std_voter')";
        $active_users2 = "AND access_rights IN ('faculty_voter', 'std_voter')";
        $active_users3  = "WHERE left(election_id,3) IN ('FCE', 'USC') OR left(election_id,4) ='LDSC'";
    }
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
                    <i class="fa fa-dashboard">&nbsp; </i> Dashboard as of  <?php echo $monthName . ' ' . $day. ', '. $year; ?>
                </h4>

                <div class="row g-4">
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="card border-left-orange shadow">
                        <div class="card-body">
                            <div class="text-xs fw-bold text-orange text-uppercase mb-1">Active Users</div>
                             <?php 
                             
                                $sql    = "SELECT * FROM tbl_users
                                           WHERE active = 'Y' $active_users";
                                $result = mysqli_query($db, $sql);           
                                $res_cnt = mysqli_num_rows($result);
                             
                             ?>  
                            <div class="h5 mb-0 fw-bold"><?php echo $res_cnt; ?></div>
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="card shadow border-left-red">
                        <div class="card-body">
                            <div class="text-xs fw-bold text-red text-uppercase mb-1">Total Voter Accounts</div>
                            <?php 
                             
                                $sql    = "SELECT * FROM tbl_users
                                           WHERE active = 'Y' $active_users2";
                                $result = mysqli_query($db, $sql);           
                                $res_cnt = mysqli_num_rows($result);
                             
                             ?> 
                            <div class="h5 mb-0 fw-bold"><?php echo $res_cnt; ?></div>
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="card border-left-yellow shadow">
                        <div class="card-body">
                            <div class="text-xs fw-bold text-yellow text-uppercase mb-1">Total Candidates</div>
                            <?php 
                             
                                $sql    = "SELECT * FROM tbl_candidates $active_users3";
                                $result = mysqli_query($db, $sql);           
                                $res_cnt = mysqli_num_rows($result);
                             
                            ?>
                            <div class="h5 mb-0 fw-bold"><?php echo $res_cnt; ?></div>
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="card border-left-maroon shadow">
                        <div class="card-body">
                            <div class="text-xs fw-bold text-maroon text-uppercase mb-1">Total Votes</div>
                            <?php 
                             
                                $sql    = "SELECT * FROM tbl_voter_status $active_users3 AND status_vote='Y'";
                                $result = mysqli_query($db, $sql);           
                                $res_cnt = mysqli_num_rows($result);
                             
                            ?>
                            <div class="h5 mb-0 fw-bold"><?php echo $res_cnt; ?></div>
                        </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="card border-0 shadow rounded-3 py-4">
                            <div class="card-body">


                                <div class="form-floating">
                                    <select id="election_id" class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                            <option value=""  selected>Select Election</option>
                                            <?php
                                                    if($access_rights =='std_admin') {
                                                        $query = "WHERE election_name IN ('LDSC','USC')";

                                                    } else if($access_rights =='faculty_admin') {
                                                        $query = "WHERE election_name ='FCE'";
                                                    }


                                                    $get = "SELECT a.election_id, a.election_name, b.description, a.date_started, b.election_type, a.status, a.department
                                                            FROM tbl_election a
                                                            LEFT JOIN tbl_election_type b
                                                            ON a.election_name = b.election_type
                                                            $query";
                                                    $res = mysqli_query($db, $get);

                                                    while ($row = mysqli_fetch_assoc($res)) {
                                                        if ($election_id == $row['election_id']) {
                                                            $xslctd = 'selected';
                                                        } else {
                                                            $xslctd = '';
                                                        }

                                                        $arry_date          = explode('/', $row['date_started']);
                                                        $election_year      = $arry_date[2] ?? '';

                                                        if ($row['election_name'] == "USC") {
                                                            $election_title = $election_year.' '.$row['description'] .' Election';
                                                        } else if ($row['election_name'] == "LDSC") {
                                                            $election_title = $election_year.' '. $row['department'].' Student Council Election';
                                                        } else if ($row['election_name'] == "FCE") {
                                                            $election_title = $election_year.' '.$row['description'] .' ('.$row['election_id'].')';
                                                        }
                                                    
                                                ?>
                                                <option value="<?php echo $row['election_id'].'|'. $row['election_type'].'|'. $row['status'].'|'. $row['election_name']; ?>" <?php echo $xslctd; ?>> <?php echo $election_title; ?></option> 
                                            <?php  } ?>   
                                    </select>
                                    <label for="floatingSelect">ELECTION</label>
                                </div>


                                <!-- Election Status Title -->
                                <h2 class="text-center mb-4 mt-3"><span class="fw-bold" id="status_election">  </span></h2>

                                <div class="alert alert-warning" role="alert" id="status-N">
                                    <h3 class="fw-bold text-center"><i class="fas fa-exclamation-circle">&nbsp;</i> ELECTION HAS NOT YET STARTED!</h3>
                                </div>

                                <div class="alert alert-warning" role="alert" id="not-selected">
                                    <h3 class="fw-bold text-center"><i class="fas fa-exclamation-circle">&nbsp;</i> PLEASE SELECT ELECTION.</h3>
                                </div>
                          
                                
                                <div id="tbl_vote_result">
                                </div>


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

    setInterval(function(){
        loadVoteResult();
    },5000);

    $('#status-N').hide();
    $('#not-selected').hide();
    $('#election_id').change(function(){
        
        loadVoteResult();
    });

    function loadVoteResult(){

        //$('#myloader').show();

        var value =  $('#election_id').val(); 
        var myarr_val       = value.split("|");
        var election_id     = myarr_val[0];
        var election_type   = myarr_val[1];
        var status          = myarr_val[2];
        var election_name   = myarr_val[3];

        if(status == 'N'){
           // var election_status     = "Election has not yet Started";
           $('#status-N').show();
           $('#not-selected').hide();
           $('#status_election').html('');
        } else if(status == 'In-Progress'){
            var election_status     = "Partial and Unofficial Result";
            $('#status-N').hide();
            $('#not-selected').hide();
        } else if(status == 'Completed'){
            var election_status     = "Official Result";
            $('#status-N').hide();
            $('#not-selected').hide();
        } else if(status == 'Undefined' || status == null){
            $('#not-selected').show();
            $('#status-N').hide();
            $('#status_election').html('');
        } 

        

        $.ajax({  
            url     :"tbl_vote_result.php",  
            method  :"POST",  
            data    :{
                        "election_id"   : election_id,
                        "election_type" : election_type,
                        "election_name" : election_name
                    },
            success:function(data){  
                if(status == 'In-Progress' || status == 'Completed'){

                    $('#tbl_vote_result').html(data);
                    $('#tbl_vote_result').show();
                } else if(status == 'N'){
                    $('#tbl_vote_result').hide();
                }
                
                //$('#myloader').hide();
                $('#status_election').html(election_status);
            }  
        });

    }
    loadVoteResult();


</script>

<?php mysqli_close($db); ?>
