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


    $sql        = "SELECT * FROM tbl_department";
    $res        = mysqli_query($db, $sql);
    $row        = mysqli_fetch_assoc($res);
    $dept_name  = $row['department'];
 
    if (!isset($_SESSION['E_Voting_System'])){
            header("Location:../");
    }

    $monthName      = date('F', mktime(0, 0, 0, date('m'), 10));
    $day            = date('d');
    $year           = date('Y');
    $date_from      = date('m/d/Y'); 


    
    $sql1    ="SELECT a.election_id, a.election_name, a.status, a.date_started, a.date_end, b.description
                FROM tbl_election a
                LEFT JOIN tbl_election_type b
                ON b.election_type=a.election_name
                WHERE a.status = 'In-Progress' AND a.election_name='USC'
                LIMIT 1";
    $res1 = mysqli_query($db,$sql1);
    $row1 = mysqli_fetch_assoc($res1);
    
    $id_election        = $row1['election_id'] ?? '';
    $election_name      = $row1['election_name'] ?? '';
    $status             = $row1['status'] ?? '';
    $description        = $row1['description'] ?? '';
    $date_started       = $row1['date_started'] ?? '';

    $arry_date          = explode('/', $date_started);
    $election_year      = $arry_date[2] ?? '';

    $sql2    ="SELECT a.election_id, a.student_id_voter, a.status_vote
                FROM tbl_voter_status a
                WHERE a.election_id = '$id_election' and student_id_voter = '$username_id'";
    $res2 = mysqli_query($db,$sql2);
    $row2 = mysqli_fetch_assoc($res2);

    $status_vote        = $row2['status_vote'] ?? '';
   

    
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
            <main class="mt-4"> 
                <div class="container col-sm-12">  

                    <?php if ($status_vote == 'Y'){ ?>

                            <section class="content-wrapper position-relative h-100">

                                <div class="card">
                                    <div class="card-header"><h4 class="fw-bold"><?php echo $election_year.' '.$description.' Election';?><h4></div>
                                    <div class="card-body align-middle">
                                        <div class="row text-center" >
                                            <?php 
                                            
                                                    $sql_res        = "SELECT b.first_name, b.middle_name, b.last_name, b.position_name, a.candidate_pos
                                                                       FROM tbl_votes a
                                                                       LEFT JOIN (SELECT c.rec_id, c.first_name, c.middle_name, c.last_name, d.position_name
                                                                                  FROM tbl_candidates c  
                                                                                  LEFT JOIN (SELECT position_name, position_id FROM tbl_position WHERE election_type='USC') d
                                                                                  ON d.position_id = c.position 
                                                                                  WHERE c.election_id='$id_election') b
                                                                        ON b.rec_id = a.candidate_id
                                                                        WHERE a.election_id = '$id_election'  AND a.student_id_voter='$username_id'";
                                                    $result = mysqli_query($db,$sql_res);
                                                    while ($row_res = mysqli_fetch_assoc($result)) {

                                                        $first_name         = $row_res['first_name'];
                                                        $middle_name        = $row_res['middle_name'];
                                                        $last_name          = $row_res['last_name'];
                                                        $position_name      = $row_res['position_name'];
                                                        $candidate_pos      = $row_res['candidate_pos'];
                                                        $candidate_name1       = $last_name.', '.$first_name.'. '.$middle_name;

                                
                                            
                                            ?>
                                                
                                                    <div class="col-sm-4 mb-4">
                                                        <div class="card-body bg-light rounded">
                                                            <div class="text-center"> 
                                                                <h5><?php echo $candidate_name1; ?></h5>
                                                                <h4 class="fw-bold"><?php echo $position_name; ?></h4>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                    
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>       
                            </section>

                    <?php } else if ($status =='In-Progress' && ($status_vote == 'N' || $status_vote == '')) {?>

                        <section class="content-wrapper position-relative h-100">
                            <h4 class="fw-bold text-center mb-4"><?php echo $election_year.' '.$description.' Election';?><h4>
                            <h5>Instructions For Voting</h5>
                            <ul class="list-unstyled">
                                <li><small>(1) Select your preferred candidate every position.</li></small>  
                                <li><small>(2) Click submit once you are finished.</small></li>
                                <li><small>(3) Make sure to review your selected candidates first before submitting because you can only submit once.</small></li>
                            </ul>
                            <div class="card mb-2 border-0 bg-light-orange">
                                <div class="card-body mx-4 pt-4 pb-2 position-relative">
                                    <h4 class="text-yellow mb-0">Reminder</h4>
                                    <h4>Be an Informed Voter</h4>
                                    <p class="fst-italic position-relative" style="max-width: 500px; z-Index: 1;">Know the Candidates | Choose Platform over Popularity | Stay updated to election procedures | Be an active voter</p>
                                    <div class="position-absolute bottom-0 end-0" style="z-Index: 0;">
                                        <img
                                            src="../../img/speech.png"
                                            alt=""
                                            class="img-fluid"
                                            width="180px"
                                        />
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
                                                        WHERE election_type='USC'
                                                        ORDER BY rec_id";
                                            $res_pos = mysqli_query($db,$sql_pos);

                                            $cnt = 1;
                                            while ($row_pos = mysqli_fetch_assoc($res_pos)) {

                                                $position_id    = $row_pos['position_id'];
                                                $position_name  = $row_pos['position_name'];

                                        ?> 

                                        <h5 class="candidate-position fw-bold mb-4 bg-red text-white text-center p-2"><?php echo $position_name; ?></h5>

                                        <?php
                                            $sql    =  "SELECT a.rec_id, a.student_id, a.first_name, a.middle_name, a.last_name, a.position, a.platform, a.election_id, a.dept_id, a.year, b.position_name
                                                        FROM tbl_candidates a  
                                                        LEFT JOIN (SELECT position_name, position_id FROM tbl_position WHERE election_type='USC') b
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
                                                $candidate_name       = $last_name.', '.$first_name.'. '.$middle_name;
                                        ?>

                                        <div class="candidate px-2 mx-auto">
                                            <label class="candidate-checkbox py-2 px-5 rounded-pill border border-2 border-light bg-light-orange" for="chkbox<?php echo $seq_no; ?>" name="wpmm[]">
                                                <div class="candidate-img img-field mr-4 rounded-circle border border-3 border-light overflow-hidden">
                                                    <img src="https://placekitten.com/400/400"  class="position-relative img-fluid">
                                                </div>
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
                                        <input type="hidden" id="PD"  value="">
                                        <input type="hidden" id="VP"  value="">
                                        <input type="hidden" id="SR"  value="">
                                        <input type="hidden" id="SF"  value="">
                                        <input type="hidden" id="SA"  value="">
                                        <input type="hidden" id="SPI"  value="">
                                        <input type="hidden" id="SBA"  value="">
                                        <input type="hidden" id="SSA"  value="">
                                        <input type="hidden" id="SSR"  value="">
                                        <input type="hidden" id="SGD"  value="">
                                    </div>    
                                </div>

                                <div class="text-center mt-3">
                                    <button id="btnVote" type="button" class="btn btn-orange btn-lg my-2">Submit your vote</button>
                                </div>
                            <form>   

                        </section>

                    <?php } else { ?>

                        <div class="alert alert-warning" role="alert" id="not-selected">
                            <h3 class="fw-bold text-center"><i class="fas fa-exclamation-circle">&nbsp;</i> No Upcoming Election.</h3>
                        </div>

                    <?php } ?>
                   
                </div>
            </main>    <br>
            <?php include($url.'footer.php'); ?>  
        </div>

    </div>
</body>
<script>

    function sendBallotReceipt(studentID, electionID) {
          
      
        $.ajax({  
            url     :"voted-email.php",  
            method  :"POST",  
            data    : {
                       "studentID"        : studentID,
                       "electionID"    : electionID
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
            var pd          = $('#PD').val(); 
            var vp          = $('#VP').val(); 
            var sr          = $('#SR').val(); 
            var sf          = $('#SF').val(); 
            var sa          = $('#SA').val(); 
            var spi         = $('#SPI').val(); 
            var sba         = $('#SBA').val(); 
            var ssa         = $('#SSA').val(); 
            var ssr         = $('#SSR').val(); 
            var sgd         = $('#SGD').val(); 

            if(positionID =="PD"){
                $('#PD').val('PD'); 
                if(pd =="PD"){
                    Swal.fire('You can only vote 1 '+ position,'', 'error') 
                    $('#chkbox'+[x]).prop('checked', false);
                } else { }
            }
            
            if(positionID =="VP"){
                $('#VP').val('VP'); 
                if(vp =="VP"){
                    Swal.fire('You can only vote 1 '+ position,'', 'error') 
                    $('#chkbox'+[x]).prop('checked', false);
                } else { }
            }

            if(positionID =="SR"){
                $('#SR').val('SR'); 
                if(sr =="SR"){
                    Swal.fire('You can only vote 1 '+ position,'', 'error') 
                    $('#chkbox'+[x]).prop('checked', false);
                } else { }
            }

            if(positionID =="SF"){
                $('#SF').val('SF'); 
                if(sf =="SF"){
                    Swal.fire('You can only vote 1 '+ position,'', 'error') 
                    $('#chkbox'+[x]).prop('checked', false);
                } else { }
            }

            if(positionID =="SA"){
                $('#SA').val('SA'); 
                if(sa =="SA"){
                    Swal.fire('You can only vote 1 '+ position,'', 'error') 
                    $('#chkbox'+[x]).prop('checked', false);
                } else { }
            }

            if(positionID =="SPI"){
                $('#SPI').val('SPI'); 
                if(spi =="SPI"){
                    Swal.fire('You can only vote 1 '+ position,'', 'error') 
                    $('#chkbox'+[x]).prop('checked', false);
                } else { }
            }

            if(positionID =="SBA"){
                $('#SBA').val('SBA'); 
                if(sba =="SBA"){
                    Swal.fire('You can only vote 1 '+ position,'', 'error') 
                    $('#chkbox'+[x]).prop('checked', false);
                } else { }
            }

            if(positionID =="SSA"){
                $('#SSA').val('SSA'); 
                if(ssa =="SSA"){
                    Swal.fire('You can only vote 1 '+ position,'', 'error') 
                    $('#chkbox'+[x]).prop('checked', false);
                } else { }
            }

            if(positionID =="SSR"){
                $('#SSR').val('SSR'); 
                if(ssr =="SSR"){
                    Swal.fire('You can only vote 1 '+ position,'', 'error') 
                    $('#chkbox'+[x]).prop('checked', false);
                } else { }
            }

            if(positionID =="SGD"){
                $('#SGD').val('SGD'); 
                if(sgd =="SGD"){
                    Swal.fire('You can only vote 1 '+ position,'', 'error') 
                    $('#chkbox'+[x]).prop('checked', false);
                } else { }
            }

        } else {

            var value       = $('#chkbox'+[x]).val(); 
            var myarr_val   = value.split("~");
            var positionID    = myarr_val[2];
            var position    = myarr_val[3];
            var pd          = $('#PD').val(); 

            if(positionID =="PD" ){
                $('#PD').val('');
            } else if (positionID =="VP") {
                $('#VP').val('');  
            } else if (positionID =="SR") {
                $('#SR').val('');  
            } else if (positionID =="SF") {
                $('#SF').val('');  
            } else if (positionID =="SA") {
                $('#SA').val('');  
            } else if (positionID =="SPI") {
                $('#SPI').val('');  
            } else if (positionID =="SBA") {
                $('#SBA').val('');  
            } else if (positionID =="SSA") {
                $('#SSA').val('');  
            } else if (positionID =="SSR") {
                $('#SSR').val('');  
            } else if (positionID =="SGD") {
                $('#SGD').val('');  
            }


            // || positionID =="VP" || positionID =="SR" || positionID =="SF" || positionID =="SA"
            //    || positionID =="SPI" || positionID =="SBA" || positionID =="SSA" || positionID =="SSR" || positionID =="SGD"

        }

    }

    $(document).on("click", "#btnVote", function(event) {
        
        event.preventDefault();
        if ($('.needs-validation')[0].checkValidity() === false) {
            Swal.fire('Kindly fill out required fields.','', 'error')
            event.stopPropagation();
        } else {  

            Swal.fire({
                title: 'Submit your Vote?',
                text: "Are you sure you want to submit you VOTE?",
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
                }
            })

        } 
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


            
            
            // // alert( position)     
            // if (position =="PD"){

            //     var cnt = 1;
            //     var count = parseInt(count + cnt);
            //     // var pd_cnt      = isNaN(parseFloat(count));
            //     alert(count)
            //     $("#PD").val(count); 


            //     // alert('You can only vote 1 ' + position)                              

            //     // if($('.chk').is(':checked')) {
                    
            //     //     //$('#chkbox2').prop('checked', false); 
            //     // }

            // } 
            
            
            var selected_recid  = chkArray_recid.join(',') 
            var selected_stid   = chkArray_stdid.join(',') 

            // alert(selected_stid)
            
        });
         
    });


</script>



</html>
<?php mysqli_close($db); ?>
