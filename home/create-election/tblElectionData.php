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
                <th class="text-center align-middle" width="2%">#</th>
                <th class="text-center" width="15%">Election ID</th>
                <th class="text-center" width="15%">Election Name</th>
                <th class="text-center" width="7%">Election Date Start</th>
                <th class="text-center" width="7%">Election Date End</th>
                <th class="text-center" width="7%">Number of Position</th>
                <th class="text-center" width="7%">Status</th>
                <th class="text-center" width="7%">Created By</th>
                <th class="text-center" width="7%">Updated By</th>
                <!-- <th class="text-center" width="10%">Active Voter?</th> -->
                <th class="text-center" width="18%">Action</th>
            </tr>
        </thead>
        <tbody class="">
            <?php

            if ($access_rights =="std_admin"){
                $query = "AND a.election_name IN ('USC','LDSC')";     
            } else if ($access_rights =="faculty_admin"){
                $query = "AND a.election_name IN ('FCE')";
            } else if ($access_rights == "SUPERADMIN") {
                $query = "AND a.election_name IN ('FCE', 'USC','LDSC')";
            }

            $sql_get = "SELECT a.rec_id, a.election_id, a.election_name, a.date_started, a.date_start_time,
                               a.date_end, a.date_end_time, a.status, b.description, a.department, a.added_by, a.updated_by
                        FROM tbl_election a
                        LEFT JOIN tbl_election_type b
                        ON a.election_name = b.election_type
                        WHERE a.status IN ('N','In-Progress') $query
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
                $date_start_time        = $row['date_start_time'];
                $date_end_time          = $row['date_end_time'];
                $added_by               = $row['added_by'];
                $updated_by             = $row['updated_by'];

                if ($status == "N"){
                    $status = "Not Started";
                } else {
                    $status = $status;
                }

                //Count candidates
                if ($election_name == "USC") {
                    $sql = "SELECT * FROM tbl_candidates
                            WHERE election_id='$election_id' 
                            GROUP BY position";
                    $qry = mysqli_query($db, $sql);
                    $cnt_candidate = mysqli_num_rows($qry) ?? '';

                    if($cnt_candidate < 9) {
                        $status_candidate = "Not Complete";
                    } else {
                        $status_candidate = "Complete";
                    }
                } else if ($election_name == "LDSC") {
                   
                    $sql = "SELECT * FROM tbl_candidates 
                            WHERE election_id='$election_id' 
                            GROUP BY position";
                    $qry = mysqli_query($db, $sql);
                    $cnt_candidate = mysqli_num_rows($qry) ?? '';
                    //$cnt_candidate = '10';
                    if($cnt_candidate < 9) {
                        $status_candidate = "Not Complete";
                    } else {
                        $status_candidate = "Complete";
                    }
                } else if ($election_name == "FCE") {
                    $sql = "SELECT * FROM tbl_candidates 
                            WHERE election_id='$election_id' 
                            GROUP BY position";
                    $qry = mysqli_query($db, $sql);
                    $cnt_candidate = mysqli_num_rows($qry) ?? '';

                    if($cnt_candidate < 7) {
                        $status_candidate = "Not Complete";
                    } else {
                        $status_candidate = "Complete";
                    }
                }
                

                $data_val               = $rec_id."|".$election_id."|".$date_started."|".$date_end."|".$status."|".$election_name."|".$department."|".$date_end."|".$date_start_time."|".$date_end_time;
                $data_val2               = $rec_id."|".$election_id."|".$status."|".$election_name."|".$cnt_candidate;
                
            ?>  
                <tr>
                    <td class="text-center align-middle"><?php echo $cnt; ?></td>
                    <td class="text-start align-middle"><?php echo $election_id;?></td>
                    <td class="text-start align-middle"><?php echo $description;?></td>
                    <td class="text-center align-middle"><?php echo $date_started.' '.$date_start_time;?></td>
                    <td class="text-center align-middle"><?php echo $date_end.' '.$date_end_time;?></td>
                    <td class="text-center align-middle"><?php echo $cnt_candidate." / ".$status_candidate;?></td>
                    <td class="text-center align-middle"><?php echo $status;?></td>
                    <td class="text-center align-middle"><?php echo $added_by;?></td>
                    <td class="text-center align-middle"><?php echo $updated_by;?></td>
                    <td class="text-center align-middle">
                        <button data-update="<?php echo $data_val; ?>" id="" type="button" class="btn btn-sm btn-success myModalUpdate" 
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Click to Edit"
                               <?php if($status =="Completed"){ echo "disabled";}else { echo "";} ?>><i class="fas fa-edit fs-5"></i>
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

<div class="table-responsive">
<h4 class="mt-5 mb-4"> Election Archive (Completed) </h4>
    <table class="table table-bordered table-hover table-light tableDark table-sm" id="dttables2">
        <thead class="nowrap">
            <tr class="table-secondary text-center th-fs"> 
                <th class="text-center align-middle" width="2%">#</th>
                <th class="text-center" width="15%">Election ID</th>
                <th class="text-center" width="15%">Election Name</th>
                <th class="text-center" width="7%">Election Date Start</th>
                <th class="text-center" width="7%">Election Date End</th>
                <th class="text-center" width="7%">Number of Position</th>
                <th class="text-center" width="7%">Status</th>
                 <th class="text-center" width="7%">Created By</th>
                <th class="text-center" width="7%">Updated By</th>
                <!-- <th class="text-center" width="10%">Active Voter?</th> -->
                <th class="text-center" width="18%">Action</th>
            </tr>
        </thead>
        <tbody class="">
            <?php

            if ($access_rights =="std_admin"){
                $query2 = "AND a.election_name IN ('USC','LDSC')";     
            } else if ($access_rights =="faculty_admin"){
                $query2 = "AND a.election_name IN ('FCE')";
            } else if ($access_rights == "SUPERADMIN") {
                $query2 = "AND a.election_name IN ('FCE', 'USC','LDSC')";
            }

            $sql_get = "SELECT a.rec_id, a.election_id, a.election_name, a.date_started, a.date_start_time,
                               a.date_end, a.date_end_time, a.status, b.description, a.department, a.added_by, a.updated_by
                        FROM tbl_election a
                        LEFT JOIN tbl_election_type b
                        ON a.election_name = b.election_type
                        WHERE a.status IN ('Completed') $query2
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
                $date_start_time        = $row['date_start_time'];
                $date_end_time          = $row['date_end_time'];
                  $added_by               = $row['added_by'];
                $updated_by             = $row['updated_by'];

                if ($status == "N"){
                    $status = "Not Started";
                } else {
                    $status = $status;
                }

                 //Count candidates
                if ($election_name == "USC") {
                    $sql = "SELECT * FROM tbl_candidates
                            WHERE election_id='$election_id' 
                            GROUP BY position";
                    $qry = mysqli_query($db, $sql);
                    $cnt_candidate = mysqli_num_rows($qry) ?? '';

                    if($cnt_candidate < 9) {
                        $status_candidate = "Not Complete";
                    } else {
                        $status_candidate = "Complete";
                    }
                } else if ($election_name == "LDSC") {
                   
                    $sql = "SELECT * FROM tbl_candidates 
                            WHERE election_id='$election_id' 
                            GROUP BY position";
                    $qry = mysqli_query($db, $sql);
                    $cnt_candidate = mysqli_num_rows($qry) ?? '';
                    //$cnt_candidate = '10';
                    if($cnt_candidate < 9) {
                        $status_candidate = "Not Complete";
                    } else {
                        $status_candidate = "Complete";
                    }
                } else if ($election_name == "FCE") {
                    $sql = "SELECT * FROM tbl_candidates 
                            WHERE election_id='$election_id' 
                            GROUP BY position";
                    $qry = mysqli_query($db, $sql);
                    $cnt_candidate = mysqli_num_rows($qry) ?? '';

                    if($cnt_candidate < 7) {
                        $status_candidate = "Not Complete";
                    } else {
                        $status_candidate = "Complete";
                    }
                }

                $data_val               = $rec_id."|".$election_id."|".$date_started."|".$date_end."|".$status."|".$election_name."|".$department."|".$date_end."|".$date_start_time."|".$date_end_time;
                $data_val2               = $rec_id."|".$election_id."|".$status;
                
            ?>  
                <tr>
                    <td class="text-center align-middle"><?php echo $cnt; ?></td>
                    <td class="text-start align-middle"><?php echo $election_id;?></td>
                    <td class="text-start align-middle"><?php echo $description;?></td>
                    <td class="text-center align-middle"><?php echo $date_started.' '.$date_start_time;?></td>
                    <td class="text-center align-middle"><?php echo $date_end.' '.$date_end_time;?></td>
                    <td class="text-center align-middle"><?php echo $cnt_candidate." / ".$status_candidate;?></td>
                    <td class="text-center align-middle"><?php echo $status;?></td>
                      <td class="text-center align-middle"><?php echo $added_by;?></td>
                    <td class="text-center align-middle"><?php echo $updated_by;?></td>
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
    $(document).ready(function() {
        $('#dttables2').DataTable({
          "lengthMenu": [[5, 25, 50, 100, -1], [ 10, 25, 50, 100, "All"]]
        });
    });

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
