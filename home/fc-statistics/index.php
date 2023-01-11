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

        #chartdiv_a {
            width: 102%;
            height: 300px;
        }
        #chartdiv_b {
            width: 102%;
            height: 300px;
        }
        #chartdiv_c {
            width: 102%;
            height: 300px;
        }
        #chartdiv_d {
            width: 102%;
            height: 300px;
        }
        #chartdiv_e {
            width: 102%;
            height: 300px;
        }
        #chartdiv_f {
            width: 102%;
            height: 300px;
        }
        #chartdiv_g {
            width: 102%;
            height: 300px;
        }
        #chartdiv_h {
            width: 102%;
            height: 300px;
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

                <h4 class="mt-5">Election Graphical Statistics <span id="graph_title"> </span></h4>

                <div class="form-floating mb-3 col-lg-12">
                    <select id="election_id" class="form-select" id="floatingSelect" aria-label="Floating label select example">
                            <option value="" selected>Select Election</option>
                            <?php
                                    if($access_rights =='std_admin') {
                                        $query = "WHERE election_name IN ('LDSC','USC')";

                                    } else if($access_rights =='faculty_admin') {
                                        $query = "WHERE election_name ='FCE'";
                                    }


                                    $get = "SELECT a.election_id, a.election_name, b.description, a.date_started, b.election_type, a.department
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
                                        $elec_id = $row['election_id'];
                                        $sql = "SELECT * FROM tbl_candidates
                                                WHERE election_id='$elec_id' 
                                                GROUP BY position";
                                        $qry = mysqli_query($db, $sql);
                                        $cnt_candidate = mysqli_num_rows($qry) ?? '';

                                      
                                    
                                ?>
                                <option value="<?php echo $row['election_id'].'|'. $row['election_type'].'|'.$cnt_candidate; ?>" <?php echo $xslctd; ?>> <?php echo $election_year.' '.$row['description'] .' ('.$row['election_id'].')'; ?></option> 
                            <?php  } ?>   
                    </select>
                    <label for="floatingSelect">ELECTION</label>
                </div>

                    <div id="tbl_vote_result"> </div>
                    <div class="row" id="graph_div">  
                        <!-- Position A -->
                        <div class="col-sm-6 mb-2">   
                            <div class="card border-0 shadow">
                               
                                <div class="card-body">
                                    <h5 class="fw-bold"><span id="post_name_a"></span></h5>
                                    <div id="chartdiv_a"></div>
                                </div>
                            </div>   
                        </div>
                       <!-- Position B -->
                        <div class="col-sm-6 mb-2">  
                            <div class="card border-0 shadow">
                           
                                <div class="card-body"> 
                                    <h5 class="fw-bold"><span id="post_name_b"></span></h5>
                                    <div id="chartdiv_b"></div>
                                </div>
                            </div>   
                        </div>     
                        <!-- Position C -->
                        <div class="col-sm-6 mb-2">   
                            <div class="card border-0 shadow">
                               
                                <div class="card-body">
                                    <h5 class="fw-bold"><span id="post_name_c"></span></h5>
                                    <div id="chartdiv_c"></div>
                                </div>
                            </div>   
                        </div>
                        <!-- Position D -->
                        <div class="col-sm-6 mb-2">   
                            <div class="card border-0 shadow">
                               
                                <div class="card-body">
                                    <h5 class="fw-bold"><span id="post_name_d"></span></h5>
                                    <div id="chartdiv_d"></div>
                                </div>
                            </div>   
                        </div>
                        <!-- Position E -->
                        <div class="col-sm-6 mb-2">   
                            <div class="card border-0 shadow">
                               
                                <div class="card-body">
                                    <h5 class="fw-bold"><span id="post_name_e"></span></h5>
                                    <div id="chartdiv_e"></div>
                                </div>
                            </div>   
                        </div>
                        <!-- Position F -->
                        <div class="col-sm-6 mb-2">   
                            <div class="card border-0 shadow">
                               
                                <div class="card-body">
                                    <h5 class="fw-bold"><span id="post_name_f"></span></h5>
                                    <div id="chartdiv_f"></div>
                                </div>
                            </div>   
                        </div>
                        <!-- Position G -->
                        <div class="col-sm-6 mb-2">   
                            <div class="card border-0 shadow">
                               
                                <div class="card-body">
                                    <h5 class="fw-bold"><span id="post_name_g"></span></h5>
                                    <div id="chartdiv_g"></div>
                                </div>
                            </div>   
                        </div>
                        <!-- Position H -->
                        <div class="col-sm-6 mb-2">   
                            <div class="card border-0 shadow">
                               
                                <div class="card-body">
                                    <h5 class="fw-bold"><span id="post_name_h"></span></h5>
                                    <div id="chartdiv_h"></div>
                                </div>
                            </div>   
                        </div>
                       

                    </div>

            

                    <div class="col-lg-12" id="no_election">   
                        <div class="card border-0 shadow">
                            
                            <div class="card-body"> 
                                <div class="alert alert-warning" role="alert" id="not-selected">
                                    <h4 class="fw-bold text-center"><i class="fas fa-exclamation-circle">&nbsp;</i> PLEASE SELECT ELECTION.</h4>
                                </div>
                            </div>
                        </div>   
                    </div>

                    <div class="col-sm-6" id="cnt_candidates">   
                        <div class="card border-0 shadow">
                            
                            <div class="card-body">
                                <div class="alert alert-warning" role="alert" id="not-selected">
                                    <h4 class="fw-bold text-center"><i class="fas fa-exclamation-circle">&nbsp;</i> Candidates for this Election is not Complete.</h4>
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
     $('#no_election').hide();
     $('#cnt_candidates').hide();
     $('#election_id').change(function(){
        
        var election_id           = $('#election_id').val(); 
        var value           = $('#election_id').val(); 
        var myarr_val       = value.split("|");
        var election_id     = myarr_val[0];
        var election_type   = myarr_val[1];
        var cnt_candidate   = myarr_val[2];
        

        if(election_id==''){
            $('#no_election').show();
            $('#graph_div').hide();
            //alert('asdas')
        } else if (cnt_candidate < 7){
            $('#graph_div').hide();
            $('#no_election').hide();
            $('#cnt_candidates').show();
        } else {
            loadVoteResult();
            $('#graph_div').show();
            $('#no_election').hide();
        }
   
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
                setTimeout(function() {
                    position_a();
                    position_b();
                    position_c();
                    position_d();
                    position_e();
                    position_f();
                    position_g();
                    position_h();
                    $('#myloader').hide();
                }, 500)
   
            }
        
        });

    }

    var election_id           = $('#election_id').val(); 
    
    if(election_id==''){
        $('#no_election').show();
        $('#graph_div').hide();
        //alert('asdas')
    } else {
        loadVoteResult();
    }
   

</script>
<?php mysqli_close($db); ?>
