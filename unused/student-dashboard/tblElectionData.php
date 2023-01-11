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

?>

<div class="table-responsive">
    
    <table class="table table-bordered table-hover table-light tableDark table-sm" id="dttables">
        <thead class="nowrap">
            <tr class="table-secondary text-center th-fs"> 
                <th class="text-center align-middle" width="3%">ID</th>
                <th class="text-center" width="17%">Election ID</th>
                <th class="text-center" width="25%">Election Name</th>
                <th class="text-center" width="12%">Election Date Start</th>
                <th class="text-center" width="12%">Election Date End</th>
                <th class="text-center" width="11%">Status</th>
                <!-- <th class="text-center" width="10%">Active Voter?</th> -->
                <th class="text-center" width="20%">Action</th>
            </tr>
        </thead>
        <tbody class="">
            <?php

            if ($access_rights =="std_admin"){
                $query = "WHERE a.election_name IN ('USC','LDSC')";     
            } else if ($access_rights =="faculty_admin"){
                $query = "WHERE a.election_name IN ('FCE')";
            }

            $sql_get = "SELECT a.rec_id, a.election_id, a.election_name, a.date_started, a.date_end, a.status, b.description, a.department
                        FROM dhvsuevo_voting.tbl_election a
                        LEFT JOIN tbl_election_type b
                        ON a.election_name = b.election_type
                        $query
                        ORDER BY a.rec_id";
            $result  = mysqli_query($db,$sql_get) or die(mysqli_error($db));
            $cnt = 1;
            while($row 	= mysqli_fetch_assoc($result)){

                $rec_id                 = $row['rec_id'];
                $election_id            = $row['election_id'];
                $election_name          = $row['election_name'];
                $date_started           = $row['date_started'];
                $date_end               = $row['date_end'];
                $status                 = $row['status'];
                $description            = $row['description'];
                $department             = $row['department'];

                if ($status == "N"){
                    $status = "Not Started";
                } else {
                    $status = $status;
                }

                $data_val               = $rec_id."|".$election_id."|".$date_started."|".$date_end."|".$status."|".$election_name."|".$department;
                $data_val2               = $rec_id."|".$election_id."|".$status;
                
            ?>  
                <tr>
                    <td class="text-center align-middle"><?php echo $cnt; ?></td>
                    <td class="text-start align-middle"><?php echo $election_id;?></td>
                    <td class="text-start align-middle"><?php echo $description;?></td>
                    <td class="text-center align-middle"><?php echo $date_started;?></td>
                    <td class="text-center align-middle"><?php echo $date_end;?></td>
                    <td class="text-center align-middle"><?php echo $status;?></td>
                    <td class="text-center align-middle">
                        <button data-update="<?php echo $data_val; ?>" id="" type="button" class="btn btn-sm btn-success myModalUpdate" 
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Click to Edit"
                               <?php if($status =="In-Progress" || $status =="Completed" || $status =="Cancelled"){ echo "disabled";}else { echo "";} ?>><i class="fas fa-edit fs-5"></i>
                        </button>
                        <button data-start="<?php echo $data_val2; ?>" id="" type="button" class="btn btn-sm btn-red start" 
                                 data-bs-toggle="tooltip" data-bs-placement="top" title="Start the Election"
                                 <?php if($status =="In-Progress" || $status =="Completed" || $status =="Cancelled"){ echo "disabled";}else { echo "";} ?> >
                                <i class="fas fa-editx"></i>Start
                        </button>
                        <button data-end="<?php echo $data_val2; ?>" id="" type="button" class="btn btn-sm btn-warning end" 
                                data-bs-toggle="tooltip" data-bs-placement="top" title="End Election" <?php if($status =="Completed" || $status =="Cancelled"){ echo "disabled";}else { echo "";} ?>>
                                <i class="fas fa-editx"></i>End
                        </button>
                        <!-- <button data-update="<?php echo $data_val2; ?>" id="" type="button" class="btn btn-sm btn-danger  cancel" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancel Election"><i class="fas fa-editx"></i>Cancel</button> -->
                    </td>
            
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
          "lengthMenu": [[5, 25, 50, 100, -1], [ 10, 25, 50, 100, "All"]]
        });
    });

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
