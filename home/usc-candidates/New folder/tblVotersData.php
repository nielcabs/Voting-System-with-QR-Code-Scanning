
<?php include_once('../../connection/mysql_connect.php'); ?>

<div class="table-responsive">
    
    <table class="table table-bordered table-hover table-light tableDark table-sm" id="dttables_user">
        <thead class="nowrap">
            <tr class="table-secondary text-center th-fs"> 
                <th class="text-center align-middle" width="3%">ID</th>
                <th class="text-center" width="10%">Student ID</th>
                <th class="text-center" width="18%">Student Name</th>
                <th class="text-center" width="17%">Department</th>
                <th class="text-center" width="7%">Year</th>
                <th class="text-center" width="10%">Position</th>
                <th class="text-center" width="25%">Election</th>
                <th class="text-center" width="10%">Action</th>
            </tr>
        </thead>
        <tbody class="">
            <?php

            $sql_get = "SELECT DISTINCT a.rec_id, a.student_id, a.first_name, a.middle_name, a.last_name, a.dept_id, a.year,
                                a.position, a. platform, a.election_id, b.election_name, c.description, d.position_name, e.department
                        FROM tbl_candidates a
                        LEFT JOIN tbl_election b
                        ON a.election_id = b.election_id
                        LEFT JOIN tbl_election_type c
                        ON b.election_name = c.election_type
                        LEFT JOIN tbl_position d
                        ON a.position = d.position_id
                        LEFT JOIN tbl_department e
                        ON a.dept_id = e.dept_id
                        WHERE c.election_type ='USC'
                        ORDER BY d.position_id";
            $result  = mysqli_query($db,$sql_get) or die(mysqli_error($db));
            $cnt = 1;
            while($row 	= mysqli_fetch_assoc($result)){

                $rec_id                 = $row['rec_id'];
                $student_id             = $row['student_id'];
                $first_name             = $row['first_name'];
                $middle_name            = $row['middle_name'];
                $last_name              = $row['last_name'];
                $deptid                 = $row['dept_id'];
                $department             = $row['department'];
                $year                   = $row['year'];
                $position               = $row['position'];
                $platform               = $row['platform'];
                $election_id            = $row['election_id'];
                $election_name          = $row['election_name'];
                $description            = $row['description'];
                $position_name          = $row['position_name'];

                $full_name              = $last_name.', '.$first_name.' '.$middle_name;


                $data_val               = $rec_id."|".$student_id."|".$first_name."|".$middle_name."|".$last_name."|".$deptid."|".$year."|".$position."|".$election_id."|".$platform;
               
            ?>  
                <tr>
                    <td class="text-center align-middle"><?php echo $cnt; ?></td>
                    <td class="text-center align-middle"><?php echo $student_id;?></td>
                    <td class="text-start align-middle"><?php echo $full_name;?></td>
                    <td class="text-start align-middle"><?php echo $department;?></td>
                    <td class="text-center align-middle"><?php echo $year;?></td>
                    <td class="text-center align-middle"><?php echo $position_name;?></td>
                    <td class="text-center align-middle"><?php echo $election_id.' / '.$description;?></td>

                    <td class="text-center align-middle">
                        <button data-update="<?php echo $data_val; ?>" id="" type="button" class="btn btn-success btn-sm myModalUpdate" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to Edit"><i class="fas fa-edit"></i></button>
                        <!-- <button data-active="<?php echo $data_active; ?>" id="" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php  if($active =="Y") { echo "Deactivate Account";}else{ echo "Activate Account";} ?>"
                                class="btn <?php  if($active =="Y") { echo "btn-success";}else{ echo "btn-danger";} ?> btn-sm act_deact">
                                <i class="fas <?php  if($active =="Y") { echo "fa-check-circle";}else{ echo "fa-times-circle";} ?>"></i>
                        </button>
                        <button data-untag="<?php echo $data_active; ?>" id="" type="button" class="btn btn-warning btn-sm untag" data-bs-toggle="tooltip" data-bs-placement="top" title="Untag as Admin"><i class="fas fa-user-times "></i></button> -->
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
        $('#dttables_user').DataTable({
          "lengthMenu": [[5, 25, 50, 100, -1], [ 10, 25, 50, 100, "All"]]
        });
    });

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
