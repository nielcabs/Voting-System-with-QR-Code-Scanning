<?php
    if (!isset($_SESSION)) {
        session_start();
    }

    $url        = "../../";
    $urlpic     = "../../";
    $addBack 	= '../home/';
    include_once($url.'connection/mysql_connect.php');
    $username_id        = $_SESSION['username_id'];
    $access_rights      = $_SESSION['access_rights'];
    $fullname           = $_SESSION['fullname'];
    $department         = $_SESSION['dept_id'];
    $chg_password       = $_SESSION['chg_password'];
    $first_name         =  $_SESSION['first_name'];
    $middle_name        = $_SESSION['middle_name'] ;
    $last_name          = $_SESSION['last_name'];
    $dept_id            = $_SESSION['dept_id'] ;
    $email              = $_SESSION['email'];

    $election_id_usc    = $_SESSION['election_id_usc'] ;
    $status_elec_usc    = $_SESSION['status_elec_usc'];
    $election_id_dept   = $_SESSION['election_id_dept'] ;
    $status_elec_dept   = $_SESSION['status_elec_dept'];

    
 
    include_once($url.'connection/session.php');

    $monthName      = date('F', mktime(0, 0, 0, date('m'), 10));
    $day            = date('d');
    $year           = date('Y');
    $date_from      = date('m/d/Y');

    
    //Select Election
    $sql1   ="SELECT a.election_id, a.election_name, a.status, a.date_started, a.date_end, b.description, a.department
              FROM tbl_election a
              LEFT JOIN tbl_election_type b
              ON b.election_type=a.election_name
              WHERE a.status = '$status_elec_dept' AND a.election_name='LDSC' AND a.department ='$dept_id'
              AND a.election_id='$election_id_dept'";
    $res1 = mysqli_query($db,$sql1);
    $row1 = mysqli_fetch_assoc($res1);
    
    $id_election        = $row1['election_id'] ?? '';
    $election_name      = $row1['election_name'] ?? '';
    $status             = $row1['status'] ?? '';
    $description        = $row1['description'] ?? '';
    $date_started       = $row1['date_started'] ?? '';
    $dept_election      = $row1['department'] ?? '';

    $arry_date          = explode('/', $date_started);
    $election_year      = $arry_date[2] ?? '';

    $sql2   ="SELECT a.election_id, a.student_id_voter, a.status_vote
                FROM tbl_voter_status a
                WHERE a.election_id = '$id_election' and student_id_voter = '$username_id'";
    $res2 = mysqli_query($db,$sql2);
    $row2 = mysqli_fetch_assoc($res2);

    $my_status_vote        = $row2['status_vote'] ?? '';


    $sql        = "SELECT * FROM tbl_department  WHERE dept_id ='$dept_id'";
    $res        = mysqli_query($db, $sql);
    $row        = mysqli_fetch_assoc($res);
    $dept_name  = $row['department'];


    $get_temp = "SELECT right((verification_code),4) voters_cnt
                FROM tbl_voter_status
                WHERE election_id='$election_id_dept' AND status_vote='Y'
                ORDER BY rec_id DESC
                LIMIT 1";
    $res_temp = mysqli_query($db, $get_temp) or die (mysqli_error($db));
    $row_temp = mysqli_fetch_assoc($res_temp);


    $voters_cnt = $row_temp['voters_cnt'] ?? '';

    if($voters_cnt =='') {
        $voters_cnt2 = "0001";
    } else {
        $voters_cnt2 = substr($voters_cnt+10001,1,4);
    }


    $vcode = rand(100000,999999);
    $ballot_receipt_code = $vcode.'-'.$voters_cnt2;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $myWebTitles; ?></title>
    <?php include_once($url.'head.php'); ?>
</head>

<body class="sb-nav-fixed">
    <div id="myloader" style="display:none;"></div>

    <div id="layoutSidenav">
        <?php include_once($url."sidebar.php"); ?>

        <div id="layoutSidenav_content">

            <main class="mt-5">
                <div class="container">  
                <input id="ballot_receipt_code" type="hidden" value="<?php echo $ballot_receipt_code; ?>">

                    <?php if ( $my_status_vote == 'Y' && $dept_id == $dept_election){ ?>
                        <section class="content-wrapper position-relative h-100">
                            <div class="row">
                                <div class="col-lg-12 mt-5">
                                    <div class="card border-0 bg-light-orange">
                                        <div class="card-body p-5">
                                            <div class="text-center">
                                                <img class="img-voted img-fluid" src="../../img/voted.png" alt="">
                                                <div class="m-5">
                                                    <h1 class="card-title">You have been successfully voted!<h1>
                                                    <h5 class="card-text">Please check your email for your ballot receipt.<h5>
                                                </div>
                                                <h6 class="card-text"><?php echo $election_year.' '.$description.' Election';?><h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                    <?php } else if ($status =='In-Progress' && ($my_status_vote == 'N' || $my_status_vote == '') && $dept_id == $dept_election) {?>

                        <!-- Vote Section -->
                        <section class="content-wrapper position-relative h-100">
                            <h4 class="title fw-bold text-center mb-4"><?php echo $election_year.' '.$dept_name.' Student Council Election';?><h4>
                            <h5 class="title">Instructions For Voting</h5>
                            <ul class="list-unstyled subtitle">
                                <li><small>(1) Select your preferred candidate every position.</li></small>  
                                <li><small>(2) Not voting for a candidate in a particular position will be an abstain.</small></li>
                                <li><small>(3) Click submit once you are finished.</small></li>
                                <li><small>(4) Make sure to review your selected candidates first before submitting because you can only submit once.</small></li>
                            </ul>
                            <div class="card mb-2 border-0 bg-light-orange">
                                <div class="card-body mx-4 pt-4 pb-2 position-relative">
                                    <div class="row">
                                        <div class="col-lg-9">
                                            <h4 class="title text-yellow mb-0">Reminder</h4>
                                            <h4 class="title">Be an Informed Voter</h4>
                                            <p class="subtitle fst-italic position-relative" style="max-width: 500px; z-Index: 1;">Know the Candidates | Choose Platform over Popularity | Stay updated to election procedures | Be an active voter</p>
                                        </div>
                                        <div class="col-lg-3" style="z-Index: 0;">
                                            <img
                                                src="../../img/speech.png"
                                                alt=""
                                                class="img-fluid"
                                                width="180px"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form method="post" class="needs-validation" novalidate>
                                <input id="id_election" type="hidden" value="<?php echo $id_election; ?>">
                                <div class="card">
                                    <div class="card-body">
                                            <?php

                                                $sql_pos    ="SELECT position_name, position_id
                                                            FROM tbl_position 
                                                            WHERE election_type='LDSC'
                                                            ORDER BY rec_id";
                                                $res_pos = mysqli_query($db,$sql_pos);

                                                $cnt = 1;
                                                while ($row_pos = mysqli_fetch_assoc($res_pos)) {

                                                    $position_id    = $row_pos['position_id'];
                                                    $position_name  = $row_pos['position_name'];
                                                    $max_vote_label = " / Vote for 1";

                                            ?>
                                                <h5 class="candidate-position fw-bold mb-4 bg-red text-white text-center p-2"><?php echo $position_name.$max_vote_label = " / Vote for 1";; ?></h5>
                                            <?php
                                                    $sql    =  "SELECT a.rec_id, a.student_id, a.first_name, a.middle_name, a.last_name, a.position, a.platform, a.election_id, a.dept_id, a.year, b.position_name, a.profile_pic
                                                                FROM tbl_candidates a  
                                                                LEFT JOIN (SELECT position_name, position_id FROM tbl_position WHERE election_type='LDSC') b
                                                                ON b.position_id = a.position
                                                                WHERE a.election_id='$id_election'
                                                                AND a.position ='$position_id'";
                                                    $result = mysqli_query($db, $sql);         

                                                
                                                    while($row    = mysqli_fetch_assoc($result)) {

                                                        $seq_no               = $cnt++;
                                                        $rec_id               = $row['rec_id'];
                                                        $student_id           = $row['student_id'];
                                                        $first_name           = $row['first_name'];
                                                        $middle_name          = $row['middle_name'];
                                                        $last_name            = $row['last_name'];
                                                        $position             = $row['position'];
                                                        $platform             = $row['platform'];
                                                        $election_id          = $row['election_id'];
                                                        $dept_id              = $row['dept_id'];
                                                        $year                 = $row['year'];
                                                        $post_name            = $row['position_name'];
                                                        $profile_pic          = $row['profile_pic'];
                                                        $candidate_name       = $last_name.', '.$first_name.'. '.$middle_name;

                                            ?>
                                            <div class="candidate px-2 mx-auto">
                                                <label class="candidate-checkbox py-2 px-5 rounded-pill border border-2 border-light bg-light-orange" for="chkbox<?php echo $seq_no; ?>" name="wpmm[]">
                                                <?php if($profile_pic =='') { ?>
                                                    <div class="candidate-img img-field mr-4 rounded-circle border border-3 border-light overflow-hidden">
                                                        <!-- <img src="https://placekitten.com/40/400"  class="position-relative img-fluid"> -->
                                                        <img class="position-relative img-fluid" src="<?php echo "../../img/speech1.png"; ?>" alt="Image">
                                                    </div>
                                                <?php } else { ?> 
                                                    <div class="candidate-img img-field mr-4 rounded-circle border border-3 border-light overflow-hidden">
                                                        <img class="position-relative img-fluid" src="<?php echo "../../".$profile_pic; ?>" alt="Image">
                                                    </div>
                                                <?php }?>
                                                <p class="mx-4 my-0 candidate-name fs-6 text-capitalize"><?php echo $candidate_name; ?></p>
                                                <input  onclick="verify(<?php echo $seq_no; ?>)" id="chkbox<?php echo $seq_no; ?>" name="wpmm[]" type="checkbox" class="form-check-input rounded-circle border-2 border-warning mt-0 chkbox" value="<?php echo $rec_id.'~'.$student_id.'~'.$position.'~'.$post_name.'~'.$election_id; ?>" >
                                                </label>
                                                <div class="vote-field d-none">
                                                    <span class="badge badge-success"><large><b></b></large></span>
                                                </div>
                                            </div>
                                            
                                            <?php
                                                    }
                                                }
                                            ?>
                                        
                                            <input type="hidden" id="len"  value="<?php echo $seq_no; ?>">
                                            <input type="hidden" id="GV"  value="">
                                            <input type="hidden" id="VG"  value="">
                                            <input type="hidden" id="BMR"  value="">
                                            <input type="hidden" id="BMF"  value="">
                                            <input type="hidden" id="BMA"  value="">
                                            <input type="hidden" id="BBA"  value="">
                                            <input type="hidden" id="BMSA"  value="">
                                            <input type="hidden" id="BMSS"  value="">
                                            <input type="hidden" id="BMPI"  value="">
                                            <input type="hidden" id="BMGD"  value="">
                                    </div>
                                </div>
                                <div class="text-center mt-3">
                                    <button id="btnVote" type="button" class="btn btn-orange btn-custom btn-lg my-2">Submit your vote</button>
                                    <!-- <button id="btnAbstain" type="button" class="btn btn-danger btn-custom btn-lg my-2 pull-right">Abstain</button> -->
                                </div>
                            <form>    
                        </section>
                        <!-- End Vote Section -->

                    <?php } else if($my_status_vote == 'A'){ ?>
                        <section class="content-wrapper position-relative h-100">
                            <div class="row">
                                <div class="col-lg-12 mt-5">
                                    <div class="card border-0 bg-light-orange">
                                        <div class="card-body p-5">
                                            <div class="text-center">
                                                <img class="img-voted img-fluid" src="../../img/disagree.png" alt="">
                                                <div class="card-text-holder m-5">
                                                    <h1 class="card-title">Abstained Vote<h1>
                                                    <p class="card-text">You have chosen not to cast your vote!</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>       
                                </div>
                            </div>
                        </section>
                    <?php } else { ?>
                        <div class="alert alert-warning" role="alert" id="not-selected">
                            <h3 class="fw-bold text-center"><i class="fas fa-exclamation-circle">&nbsp;</i> No Election In-Progress</h3>
                        </div>
                    <?php } ?>
                </div>
            </main>
            <?php include($url.'footer.php'); ?>
        </div>
    </div>
</body>

<script>
    function sendBallotReceipt(studentID, electionID) {
        var ballot_receipt_code     = $('#ballot_receipt_code').val(); 
        $.ajax({  
            url     :"voted-email.php",  
            method  :"POST",  
            data    : {
                        "studentID"             : studentID,
                        "electionID"            : electionID,
                        "ballot_receipt_code"   : ballot_receipt_code
                    },
            success:function(response){    

            },//Success-END
            error: function(XMLHttpRequest, textStatus, errorThrown){
                swal.fire({title: "Oops...",text: "Please check your internet connection and try again.",type: "error",confirmButtonColor: '#4e73df'})
            }
        }); //AJAX END
  
    }

    function verify(x) {
        if ($('#chkbox'+[x]).is(":checked")) {
        
            var value       = $('#chkbox'+[x]).val(); 
            var myarr_val   = value.split("~");
            var positionID  = myarr_val[2];
            var position    = myarr_val[3];
            var gv          = $('#GV').val(); 
            var vg          = $('#VG').val(); 
            var bmr         = $('#BMR').val(); 
            var bmf         = $('#BMF').val(); 
            var bma         = $('#BMA').val(); 
            var bba         = $('#BBA').val(); 
            var bmsa        = $('#BMSA').val(); 
            var bmss        = $('#BMSS').val(); 
            var bmpi        = $('#BMPI').val(); 
            var bmgd        = $('#BMGD').val(); 

            if(positionID =="GV"){
                $('#GV').val('GV'); 
                if(gv =="GV"){
                    Swal.fire('You can only vote 1 '+ position,'', 'error') 
                    $('#chkbox'+[x]).prop('checked', false);
                } else { }
            }
            
            if(positionID =="VG"){
                $('#VG').val('VG'); 
                if(vg =="VG"){
                    Swal.fire('You can only vote 1 '+ position,'', 'error') 
                    $('#chkbox'+[x]).prop('checked', false);
                } else { }
            }

            if(positionID =="BMR"){
                $('#BMR').val('BMR'); 
                if(bmr =="BMR"){
                    Swal.fire('You can only vote 1 '+ position,'', 'error') 
                    $('#chkbox'+[x]).prop('checked', false);
                } else { }
            }

            if(positionID =="BMF"){
                $('#BMF').val('BMF'); 
                if(bmf =="BMF"){
                    Swal.fire('You can only vote 1 '+ position,'', 'error') 
                    $('#chkbox'+[x]).prop('checked', false);
                } else { }
            }

            if(positionID =="BMA"){
                $('#BMA').val('BMA'); 
                if(bma =="BMA"){
                    Swal.fire('You can only vote 1 '+ position,'', 'error') 
                    $('#chkbox'+[x]).prop('checked', false);
                } else { }
            }

            if(positionID =="BBA"){
                $('#BBA').val('BBA'); 
                if(bba =="BBA"){
                    Swal.fire('You can only vote 1 '+ position,'', 'error') 
                    $('#chkbox'+[x]).prop('checked', false);
                } else { }
            }

            if(positionID =="BMSA"){
                $('#BMSA').val('BMSA'); 
                if(bmsa =="BMSA"){
                    Swal.fire('You can only vote 1 '+ position,'', 'error') 
                    $('#chkbox'+[x]).prop('checked', false);
                } else { }
            }

            if(positionID =="BMSS"){
                $('#BMSS').val('BMSS'); 
                if(bmss =="BMSS"){
                    Swal.fire('You can only vote 1 '+ position,'', 'error') 
                    $('#chkbox'+[x]).prop('checked', false);
                } else { }
            }

            if(positionID =="BMPI"){
                $('#BMPI').val('BMPI'); 
                if(bmpi =="BMPI"){
                    Swal.fire('You can only vote 1 '+ position,'', 'error') 
                    $('#chkbox'+[x]).prop('checked', false);
                } else { }
            }

            if(positionID =="BMGD"){
                $('#BMGD').val('BMGD'); 
                if(bmgd =="BMGD"){
                    Swal.fire('You can only vote 1 '+ position,'', 'error') 
                    $('#chkbox'+[x]).prop('checked', false);
                } else { }
            }

        } else {

            var value       = $('#chkbox'+[x]).val(); 
            var myarr_val   = value.split("~");
            var positionID    = myarr_val[2];
            var position    = myarr_val[3];

            if(positionID =="GV" ){
                $('#GV').val('');
            } else if (positionID =="VG") {
                $('#VG').val('');  
            } else if (positionID =="BMR") {
                $('#BMR').val('');  
            } else if (positionID =="BMF") {
                $('#BMF').val('');  
            } else if (positionID =="BMA") {
                $('#BMA').val('');  
            } else if (positionID =="BBA") {
                $('#BBA').val('');  
            } else if (positionID =="BMSA") {
                $('#BMSA').val('');  
            } else if (positionID =="BMSS") {
                $('#BMSS').val('');  
            } else if (positionID =="BMPI") {
                $('#BMPI').val('');  
            } else if (positionID =="BMGD") {
                $('#BMGD').val('');  
            }

            // || positionID =="VP" || positionID =="SR" || positionID =="SF" || positionID =="SA"
            //    || positionID =="SPI" || positionID =="SBA" || positionID =="SSA" || positionID =="SSR" || positionID =="SGD"
        }
    }

    $(document).on("click", "#btnVote", function(event) {

        var gv          = $('#GV').val(); 
        var vg          = $('#VG').val(); 
        var bmr         = $('#BMR').val(); 
        var bmf         = $('#BMF').val(); 
        var bma         = $('#BMA').val(); 
        var bba         = $('#BBA').val(); 
        var bmsa        = $('#BMSA').val(); 
        var bmss        = $('#BMSS').val(); 
        var bmpi        = $('#BMPI').val(); 
        var bmgd        = $('#BMGD').val(); 

        event.preventDefault();

        if (gv !='' && vg !='' && bmr !='' && bmf !='' && bma !='' && bba !='' && bmsa !='' && bmss !='' && bmpi !='' && bmgd !='') {
            var label_no_vote = "";
        } else { 
            var label_no_vote = "<h5>You didn't select for the postion of :</h5>";
        }

        if(gv =="" ){
           var pos_GV = "Governor";
           var pos_GV_br = "<br>";
        } else { var pos_GV = ""; var pos_GV_br = "";}

        if (vg =="") {
            var pos_VG = "Vice-Governor"; 
            var pos_VG_br = "<br>";
        } else { var pos_VG = ""; var pos_VG_br = "";}

        if (bmr =="") {
            var pos_BMR = "Board Member on Records"; 
            var pos_BMR_br = "<br>";
        } else { var pos_BMR = ""; var pos_BMR_br = "";}

        if (bmf =="") {
            var pos_BMF = "Board Member on Records";  
            var pos_BMF_br = "<br>";
        } else { var pos_BMF = ""; var pos_BMF_br = "";}

        if (bma =="") {
            var pos_BMA = "Board Member on Audit"; 
            var pos_BMA_br = "<br>";
        } else { var pos_BMA = ""; var pos_BMA_br = "";}

        if (bba =="") {
            var pos_BBA = "Board Member on Business Affair";
            var pos_BBA_br = "<br>";
        } else { var pos_BBA = "";  var pos_BBA_br = "";}

        if (bmsa =="") {
            var pos_BMSA = "Board Member on Student Affair"; 
            var pos_BMSA_br = "<br>";
        } else { var pos_BMSA = ""; var pos_BMSA_br = "";}

        if (bmss =="") {
            var pos_BMSS = "Board Member on Student Services";
            var pos_BMSS_br = "<br>";
        } else { var pos_BMSS = ""; var pos_BMSS_br = "";}

        if (bmpi =="") {
            var pos_BMPI = "Board Member on Public Information";
            var pos_BMPI_br = "<br>";
        } else { var pos_BMPI = "";  var pos_BMPI_br = "";}

        if (bmgd =="") {
            var pos_BMGD = "Board Member on Gender and Development";
            var pos_BMGD_br = "<br>";
        } else { var pos_BMGD = ""; var pos_BMGD_br = "";}


        // if ($('.needs-validation')[0].checkValidity() === false) {
        //     Swal.fire('Kindly fill out required fields.','', 'error')
        //     event.stopPropagation();
        // } 
        // if (gv=='' || vg=='' || bmr=='' || bmf=='' || bma=='' || bba=='' || bmsa=='' || bmss=='' || bmpi=='' || bmgd=='') {
        //     Swal.fire('Kindly Vote atleast 1 per Position, Please check you Votes','', 'error')
        //     event.stopPropagation();
        // } else {
            Swal.fire({
                title: 'Submit your Vote?',
                html: label_no_vote+"<h5 class='text-red mt-n4'>"+pos_GV+pos_GV_br+pos_VG+pos_VG_br+pos_BMR+pos_BMR_br+pos_BMF+pos_BMF_br+pos_BMA+pos_BMA_br+pos_BBA+pos_BBA_br+pos_BMSA+pos_BMSA_br+pos_BMSS+pos_BMSS_br+pos_BMPI+pos_BMPI_br+pos_BMGD+"</h5><br><h4>Are you sure you want to submit your VOTE?</h4>",
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
                        saveVote();
                    }, 2000)
                })
            }})
        //}

        $('.needs-validation').addClass('was-validated');
    });

    function saveVote() {
        var id_election         = $('#id_election').val(); 
        var chkArray_recid      = [];
        var chkArray_stdid      = [];
        var chkArray_pos        = [];
        var chkArray_elecid     = [];

        $('input:checkbox:checked').each(function() {

            var id_map = $(this).val();

            var myarr_test = id_map.split("~");
            
            var rec_id          = myarr_test[0];
            var student_id      = myarr_test[1];
            var position        = myarr_test[2];
            var election_id     = myarr_test[4];

            chkArray_recid.push(rec_id);
            chkArray_stdid.push(student_id);
            chkArray_pos.push(position);
            chkArray_elecid.push(election_id);
       
            var selected_recid      = chkArray_recid.join(',')
            var selected_stid       = chkArray_stdid.join(',')
            var selected_pos        = chkArray_pos.join(',')
            var selected_elecid     = chkArray_elecid.join(',')

        });

            var selected_recid  = chkArray_recid.join(',')
            var selected_stid   = chkArray_stdid.join(',')
            var selected_pos    = chkArray_pos.join(',')
            var selected_elecid     = chkArray_elecid.join(',')

            $('#btnVote').prop("disabled", true);
            $('#btnAbstain').prop("disabled", true);  
            $.ajax({  //START AJAX
 
            type: 	"POST",
            url	:   'save.php',
            data:{      "selected_recid"    :   selected_recid,
                        "selected_stid"     :   selected_stid,
                        "selected_pos"      :   selected_pos,
                        "selected_elecid"   :   selected_elecid,
                        "id_election"       :   id_election
                },
            success : function(response) {

                var myresponse = response.split('|');
        
                if ($.trim(myresponse[0]) == 'Relogin') {
                    Swal.fire({
                        title: "Unable to save record, Your session has expired. Please re-login.",
                        text: "",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#4e73df',
                        cancelButtonColor: '#858796',
                        confirmButtonText: 'OK',
                        cancelButtonText: 'NO',
                        allowOutsideClick: false
                    }).then((isConfirm) => {
                        if (isConfirm.value) {
                            location.reload();
                        }
                    })
                } else if ($.trim(myresponse[0]) === 'Saved') {
                    //Swal.fire('Successfully Voted.','', 'success')  
                    Swal.fire({
                        title: "You have Successfully Voted.",
                        text: "",
                        type: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#4e73df',
                        cancelButtonColor: '#858796',
                        confirmButtonText: 'OK',
                        cancelButtonText: 'NO',
                        allowOutsideClick: false
                    }).then((isConfirm) => {
                        if (isConfirm.value) {

                            var   studentID  = $.trim(myresponse[1]);
                            var   electionID = $.trim(myresponse[2]);
                            sendBallotReceipt(studentID, electionID)

                            setTimeout(function() {
                           
                                location.reload();
                            }, 500)
                        }
                    })
                }  else {
                    Swal.fire('Error Saving.','', 'error') 
                    $('#btnVote').prop("disabled", false);  
                    $('#btnAbstain').prop("disabled", false);  
                }
            },
                error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                swal.fire({title: "Oops...",text: "Please check your internet connection and try again.",type: "error",confirmButtonColor: '#4e73df'})
            }
        });/////AJAX END
    }

    $('.chkbox').click(function(){

        var chkArray_recid  = [];
        var chkArray_stdid = [];
        $('input:checkbox:checked').each(function() {

            var id_map = $(this).val();

            var myarr_test = id_map.split("~");

            var rec_id      = myarr_test[0];
            var student_id  = myarr_test[1];
            var position    = myarr_test[2];

            chkArray_recid.push(rec_id);
            chkArray_stdid.push(student_id);

            var selected_recid  = chkArray_recid.join(',') 
            var selected_stid   = chkArray_stdid.join(',') 

            // alert(selected_stid)
        });

    });



    $(document).on("click", "#btnAbstain", function(event) {

        Swal.fire({
            title: 'Abstain from Voting?',
            text: "Are you sure you don't want to Cast your Vote?",
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
                    abstainVote();
                }, 2000)
            })
            }
        })
      
    });

    function abstainVote() {

        var id_election         = $('#id_election').val(); 

        $('#btnVote').prop("disabled", true);  
        $('#btnAbstain').prop("disabled", true);  
        $.ajax({  //START AJAX
                
            type: 	"POST",
            url	:   'abstain.php',
            data:{     
                    "id_election"       :   id_election
                },
            success : function(response) {

                var myresponse = response.split('|');     
                
                if ($.trim(myresponse[0]) == 'Relogin') { 
                    Swal.fire({
                            title: "Unable to save record, Your session has expired. Please re-login.",
                            text: "",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#4e73df',
                            cancelButtonColor: '#858796',
                            confirmButtonText: 'OK',
                            cancelButtonText: 'NO',
                            allowOutsideClick: false
                    }).then((isConfirm) => {
                        if (isConfirm.value) {
                            location.reload();
                        }
                    })
                } else if ($.trim(myresponse[0]) === 'Saved') {
                    //Swal.fire('Successfully Voted.','', 'success')  
                    Swal.fire({
                            title: "You have Abstained your Vote.",
                            text: "",
                            type: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#4e73df',
                            cancelButtonColor: '#858796',
                            confirmButtonText: 'OK',
                            cancelButtonText: 'NO',
                            allowOutsideClick: false
                    }).then((isConfirm) => {
                        if (isConfirm.value) {

                            setTimeout(function() {
                           
                                location.reload();
                            }, 500)
                         
                        }
                    })
                }  else {
                    Swal.fire('Error Saving.','', 'error') 
                    $('#btnVote').prop("disabled", false);  
                    $('#btnAbstain').prop("disabled", false);  
                }
            
            },
                error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                swal.fire({title: "Oops...",text: "Please check your internet connection and try again.",type: "error",confirmButtonColor: '#4e73df'})
            }
        });/////AJAX END
    }

</script>

</html>

<?php mysqli_close($db); ?>
