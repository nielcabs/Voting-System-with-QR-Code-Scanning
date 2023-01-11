<?php
    if (!isset($_SESSION)) { 
        session_start(); 
    } 
    $addBack 	= '../home/';
    $url        = "../";
    include_once($url.'connection/mysql_connect.php');

    $election_id        = $_POST['election_id'] ?? ''; 
    $election_type      = $_POST['election_type'] ?? ''; 
    $election_name      = $_POST['election_name'] ?? ''; 

    $arry_eid           = explode('-',  $election_id);
    $dept_id            = $arry_eid[1] ?? '';

    if($election_name =='LDSC') {

        $sql     = "SELECT dept_id, department
                    FROM tbl_department
                    WHERE dept_id='$dept_id'";
        $result  = mysqli_query($db, $sql);
        $row     = mysqli_fetch_assoc($result);
        
        $depart_name          = $row['department'] ?? '';
        
        $title_total_a          = "Total Number of Registered Voters for ".strtoupper($dept_id);
        $title_total_b          = "Total Number of Voters that Actually Voted for ".strtoupper($dept_id);
        
        $sql    = "SELECT * FROM tbl_users
                    WHERE active = 'Y' AND dept_id='$dept_id' AND access_rights IN ('std_voter')";
        $result = mysqli_query($db, $sql);           
        $registered_voters = mysqli_num_rows($result);
        
        
        $sql1    = "SELECT * 
                    FROM tbl_voter_status a
                    LEFT JOIN tbl_election b
                    ON a.election_id = b.election_id
                    WHERE a.election_id = '$election_id' AND b.department='$dept_id'";
        $result1 = mysqli_query($db, $sql1);           
        $total_actual_votes = mysqli_num_rows($result1);

        //Check of odd or even #
        if($registered_voters % 2 == 0){
            //echo "Even"; 
            $total_vote_needs    = ($registered_voters * .50) + 1;
        } else {
            //echo "Odd";
            $total_vote_needs    = number_format($registered_voters * .50,0);
        }

       
    } else if ($election_name =='USC'){

        
        $title_total_a          = "Total Number of Registered Voters";
        $title_total_b          = "Total Number of Voters that Actually Voted";
        
        $sql    = "SELECT * FROM tbl_users
                    WHERE active = 'Y' AND access_rights IN ('std_voter')";
        $result = mysqli_query($db, $sql);           
        $registered_voters = mysqli_num_rows($result);
        
        $sql1    = "SELECT * 
                    FROM tbl_voter_status a
                    LEFT JOIN tbl_election b
                    ON a.election_id = b.election_id
                    WHERE a.election_id = '$election_id'";
        $result1 = mysqli_query($db, $sql1);           
        $total_actual_votes = mysqli_num_rows($result1);

        //Check of odd or even #
        if($registered_voters % 2 == 0){
            //echo "Even"; 
            $total_vote_needs    = ($registered_voters * .50) + 1;
        } else {
            //echo "Odd";
            $total_vote_needs    = number_format($registered_voters * .50,0);
        }
    } else if ($election_name =='FCE'){

        
        $title_total_a          = "Total Number of Registered Voters";
        $title_total_b          = "Total Number of Voters that Actually Voted";
        
        $sql    = "SELECT * FROM tbl_users
                    WHERE active = 'Y' AND access_rights IN ('faculty_voter')";
        $result = mysqli_query($db, $sql);           
        $registered_voters = mysqli_num_rows($result);
        
        $sql1    = "SELECT * 
                    FROM tbl_voter_status a
                    LEFT JOIN tbl_election b
                    ON a.election_id = b.election_id
                    WHERE a.election_id = '$election_id'";
        $result1 = mysqli_query($db, $sql1);           
        $total_actual_votes = mysqli_num_rows($result1);

        //Check of odd or even #
        if($registered_voters % 2 == 0){
            //echo "Even"; 
            $total_vote_needs    = ($registered_voters * .50) + 1;
        } else {
            //echo "Odd";
            $total_vote_needs    = number_format($registered_voters * .50,0);
        }
    }

?>

<p class=""><?php echo $title_total_a; ?> : <?php echo $registered_voters?></p>
<p class=""><?php echo $title_total_b; ?> : <?php echo $total_actual_votes?></p>
<p class="">Total Number of Votes needed to Win : <?php echo $total_vote_needs?></p>

<div class="row gy-2">
    <?php

        $sql_pos    ="SELECT position_name, position_id
                    FROM tbl_position 
                    WHERE election_type='$election_type'
                    ORDER BY rec_id";
        $res_pos = mysqli_query($db,$sql_pos);

        $cnt = 1;
        while ($row_pos = mysqli_fetch_assoc($res_pos)) {

            $position_id    = $row_pos['position_id'];
            $position_name  = $row_pos['position_name'];

    ?> 
                
                <div class="col-lg-6">
                    <div class="card mb-2">
                        <div class="card-header text-white fw-bold">
                            <?php echo $position_name; ?>
                        </div>

                        <div class="card-body">
            

                            <?php
                                    $sql    =  "SELECT a.rec_id, a.student_id, a.first_name, a.middle_name, a.last_name,
                                                    a.position, a.platform, a.election_id, a.dept_id, a.year, b.position_name, a.vote_count
                                                FROM tbl_candidates a  
                                                LEFT JOIN (SELECT position_name, position_id FROM tbl_position WHERE election_type='$election_type') b
                                                ON b.position_id = a.position
                                                WHERE a.election_id='$election_id'
                                                AND a.position ='$position_id'";
                                    $result = mysqli_query($db, $sql);         

                                    $count = 1;
                                    while($row    = mysqli_fetch_assoc($result)) {

                                        $seq_no               = $cnt++;
                                        $seq_no2              = $count++;
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
                                        $vote_count           = $row['vote_count'] ?? "0";
                                        $candidate_name       = $last_name.', '.$first_name.'. '.$middle_name;

                            
                                        $sql1           = "SELECT * FROM tbl_users
                                                            WHERE active = 'Y' and access_rights = 'std_voter'";
                                        $result1        = mysqli_query($db, $sql1);           
                                        $total_voter    = mysqli_num_rows($result1);

                                        $vote_perc      = number_format(($vote_count / $total_voter) * 100,0);

                            ?>

                
                                <div class="row">
                                    <div class="col-sm-5">
                                        <?php echo $seq_no2; ?>.
                                        <?php echo $candidate_name; ?>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="progress mt-1">
                                            <div class="progress-bar" role="progressbar" aria-label="Basic example" style="width: <?php echo $vote_perc.'%'; ?>" aria-valuenow="<?php echo $vote_count; ?>" aria-valuemin="0" aria-valuemax="<?php echo $total_voter; ?>"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 fw-bold">
                                        <?php echo $vote_count; ?>
                                    </div>
                                </div>
    <?php
            
                                    }
    ?>
                        </div>
                    </div>
                </div>  
                
    <?php  
        }
    ?>
</div>
