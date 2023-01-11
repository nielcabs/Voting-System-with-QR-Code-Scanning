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


    $election_id        = $_POST['election_id'] ?? ''; 
    $election_type      = $_POST['election_type'] ?? ''; 

?>

<div class="table-responsive">
    
    <table class="table table-bordered table-hover table-light tableDark table-sm" id="dttables">
        <thead class="nowrap">
            <tr class="table-secondary text-center th-fs"> 
                <th class="text-center align-middle" width="5%">#</th>
                <th class="text-center" width="30%">Candidate Name</th>
                <th class="text-center" width="20%">Position</th>
                <th class="text-center" width="35%">Vote Percentage</th>
                <th class="text-center" width="10%">Vote Count</th>
            </tr>
        </thead>
        <tbody class="">
            <?php

                $sql    =  "SELECT a.rec_id, a.student_id, a.first_name, a.middle_name, a.last_name,
                                a.position, a.platform, a.election_id, a.dept_id, a.year, b.position_name, a.vote_count
                            FROM tbl_candidates a  
                            LEFT JOIN (SELECT rec_id, position_name, position_id FROM tbl_position WHERE election_type='$election_type') b
                            ON b.position_id = a.position
                            WHERE a.election_id='$election_id'
                            ORDER BY b.rec_id";
                $result = mysqli_query($db, $sql);         

                $count = 1;
                while($row    = mysqli_fetch_assoc($result)) {

                   
                    $seq_no                 = $count++;
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

                    $vote_perc      = number_format(($vote_count / $total_voter) * 100,2);
                
            ?>  
                <tr>
                    <td class="text-center align-middle"><?php echo $seq_no; ?></td>
                    <td class="text-start align-middle"><?php echo $candidate_name;?></td>
                    <td class="text-start align-middle"><?php echo $post_name;?></td>
                    <td class="text-center align-middle">
                        <div class="row">
                            <div class="col-sm-2">
                                <?php echo $vote_perc.'%';?>
                            </div>
                            <div class="col-sm-10">
                                <div class="progress mt-1">
                                    <div class="progress-bar" role="progressbar" aria-label="Basic example" style="width: <?php echo $vote_perc.'%'; ?>" aria-valuenow="<?php echo $vote_count; ?>" aria-valuemin="0" aria-valuemax="<?php echo $total_voter; ?>"></div>
                                </div>
                            </div>
                        </div>
                   </td>
                    <td class="text-center align-middle"><?php echo $vote_count;?></td>
            
                </tr>
            <?php
             
            }
            ?>
        </tbody>
    </table>

</div>
<script>
    $(document).ready(function() {
        $('#dttables').DataTable({
          "lengthMenu": [[5, 25, 50, 100, -1], [ 10, 25, 50, 100, "All"]],
          paging: false
        });
    });

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
