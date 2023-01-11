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

                <h4 class="mt-5">
                    Election Result
                </h4>
               

                <div class="form-floating col-lg-12">
                    <select id="election_id" class="form-select" id="floatingSelect" aria-label="Floating label select example">
                         <option value=""  selected>Select Election</option>
                            <?php
                                    if($access_rights =='std_admin') {
                                        $query = "WHERE election_name IN ('LDSC','USC')";

                                    } else if($access_rights =='faculty_admin') {
                                        $query = "WHERE election_name ='FCE'";
                                    }


                                    $get = "SELECT a.election_id, a.election_name, b.description, a.date_started, b.election_type
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

                                
                                    
                                ?>
                                <option value="<?php echo $row['election_id'].'|'. $row['election_type']; ?>" <?php echo $xslctd; ?>> <?php echo $election_year.' '.$row['description'] .' ('.$row['election_id'].')'; ?></option> 
                            <?php  } ?>   
                    </select>
                    <label for="floatingSelect">ELECTION</label>
                </div>
                <button id="btnPrint" type="button" class="btn btn-orange btn-xl my-4"><span class="p-3"><i class="fa fa-print">&nbsp;</i>Print PDF</span></button>
                <div class="card border-0 shadow">
                    <div class="card-body"> 
                    <div id="tbl_vote_result"> </div>
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

    $("#btnPrint").click(function(){

        var value           = $('#election_id').val(); 
        var myarr_val       = value.split("|");
        var election_id     = myarr_val[0];
        var election_type   = myarr_val[1];

        var etype                = "&etype=";

        if(value==''){
            Swal.fire('Kindly Select Election.','', 'error')
        } else {
            setTimeout(function(){
                window.open ("print-election.php?eid="+election_id+etype+election_type,"");
            }, 500);
        }

      
        
    });


    $('#election_id').change(function(){
        
        loadVoteResult();
    });

    function loadVoteResult(){

        $('#myloader').show();

        var value           = $('#election_id').val(); 
        var myarr_val       = value.split("|");
        var election_id     = myarr_val[0];
        var election_type   = myarr_val[1];

        $.ajax({  
            url     :"tblElectionResult.php",  
            method  :"POST",  
            data    :{
                        "election_id"   : election_id,
                        "election_type" : election_type
                    },
            success:function(data){  
                $('#tbl_vote_result').html(data);
                $('#myloader').hide();
            }  
        });

    }
    loadVoteResult();





</script>



<?php mysqli_close($db); ?> -->
