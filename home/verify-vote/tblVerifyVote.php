<?php 

    if (!isset($_SESSION)) { 
        session_start(); 
    }
    $username_id         = $_SESSION['username_id'];
    $access_rights       = $_SESSION['access_rights'];
    $fullname            = $_SESSION['fullname'];
    $department          = $_SESSION['department'];
    $chg_password        = $_SESSION['chg_password'];
    include_once('../../connection/mysql_connect.php'); 



    
    $verify_code        = $_POST['verify_code'] ?? null;

    
    $sql    = "SELECT * FROM tbl_voter_status        
               WHERE verification_code='$verify_code'";
    $result = mysqli_query($db,$sql);
    $row    = mysqli_fetch_assoc($result);

    $electionID         = $row['election_id'] ?? null;
    $student_id_voter   = $row['student_id_voter'] ?? null;

    $arry_election_type = explode('-', $electionID);
    $election_type       = $arry_election_type[0];
?>

<div class="table-responsive">
    
    <table class="table table-bordered table-hover table-light tableDark table-sm" id="dttables">
        <thead class="nowrap">
            <tr class="table-secondary text-center th-fs"> 
                <th class="text-center align-middle" width="3%">#</th>
                <th class="text-center" width="17%">Position</th>
                <th class="text-center" width="25%">Candidate Name</th>
                
            </tr>
        </thead>
        <tbody class="">
            <?php

                    $sql    = "SELECT a.student_id_voter, b.rec_id as candidate_id, b.first_name, b.middle_name, b.last_name, b.position_name
                                FROM tbl_votes a
                                LEFT JOIN (SELECT c.rec_id, c.first_name, c.middle_name, c.last_name, c.position, d.position_name , c.election_id
                                           FROM tbl_candidates c
                                           LEFT JOIN tbl_position d
                                           ON c.position = d.position_id 
                                           WHERE c.election_id = '$electionID'  and d.election_type='$election_type ') b
                                ON b.rec_id = a.candidate_id AND a.candidate_pos = b.position          
                                WHERE a.student_id_voter ='$student_id_voter' AND a.election_id='$electionID'";
                    $result = mysqli_query($db,$sql);
                    $cnt = 1;
                    while($row = mysqli_fetch_assoc($result)) {

                    $position_name      = $row['position_name'];
                    $candidate_name     = $row['last_name'].', '.$row['first_name'].' '.$row['middle_name'];
                                    
            ?>  
                <tr>
                    <td class="text-center align-middle"><?php echo $cnt; ?></td>
                    <td class="text-start align-middle"><?php echo $position_name;?></td>
                    <td class="text-start align-middle"><?php echo $candidate_name;?></td>
                  
            
                </tr>
            <?php
                $cnt++;
            }
            ?>
        </tbody>
    </table>

</div>
<script>
    $(document).ready(function() {
        $('#dttables').DataTable({
          "lengthMenu": [[100, -1], [ 100, "All"]]
        });
    });

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
