
<?php include_once('../../connection/mysql_connect.php'); ?>

<div class="table-responsive">
    
    <table class="table table-bordered table-hover table-light tableDark table-sm" id="dttables_user">
        <thead class="nowrap">
            <tr class="table-secondary text-center th-fs"> 
                <th class="text-center align-middle" width="3%">#</th>
                <th class="text-center align-middle" width="3%">Picture</th>
                <th class="text-center" width="10%">StudentID</th>
                <th class="text-center" width="18%">Student Name</th>
                <th class="text-center" width="17%">Department</th>
                <th class="text-center" width="7%">Year</th>
                <th class="text-center" width="10%">Position</th>
                <th class="text-center" width="10%">Party</th>
                <th class="text-center" width="25%">Election</th>
                <th class="text-center" width="10%">Action</th>
            </tr>
        </thead>
        <tbody class="">
            <?php

            $sql_get = "SELECT DISTINCT a.rec_id, a.student_id, a.first_name, a.middle_name, a.last_name, a.dept_id, a.year,
                                a.position, a. platform, a.election_id, b.election_name, c.description, d.position_name, e.department, a.profile_pic, a.party_name, a.election_status
                        FROM tbl_candidates a
                        LEFT JOIN tbl_election b
                        ON a.election_id = b.election_id
                        LEFT JOIN tbl_election_type c
                        ON b.election_name = c.election_type
                        LEFT JOIN (SELECT position_id, position_name FROM tbl_position WHERE election_type ='LDSC') d
                        ON a.position = d.position_id
                        LEFT JOIN tbl_department e
                        ON a.dept_id = e.dept_id
                        WHERE c.election_type ='LDSC'
                        ORDER BY rec_id DESC, d.position_id";
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
                $profile_pic            = $row['profile_pic'];
                $party_name             = $row['party_name'];
                $election_status        = $row['election_status'];

                $mname_sub          = substr($middle_name,0,1);
                $fullname           = $first_name.' '.$mname_sub.'. '.$last_name;
                $full_name          = $last_name.', '.$first_name.' '.$middle_name;



                
                $fname_explode = explode(". ","$fullname");

                $fname = $fname_explode[0];
                $fname_ex = explode(" ","$fname");

                $first_name = $fname_ex[0];
                $m_initials = $fname_ex[1];
                $last_name = $fname_explode[1];

                if (strpos($last_name,' ') !== false) { 
                    $lname = explode(" ","$last_name");
                    $last_name = $lname[0];
                } else {
                    $last_name = $fname_explode[1];
                }

                $words = explode(" ", $first_name.' '. $m_initials.' '.$last_name);
                $initials = null;
                foreach ($words as $w) {
                    $initials .= $w[0] ?? null;
                }
                $initials;


                $data_val               = $rec_id."|".$student_id."|".$first_name."|".$middle_name."|".$last_name."|".$deptid."|".$year."|".$position."|".$election_id."|".$platform."|".$party_name."|".$election_status;
               
            ?>  
                <tr>
                    <td class="text-center align-middle"><?php echo $cnt; ?></td>
                    <td class="text-center align-middle">
                        <?php if($profile_pic !=''){?>
                            <img width="50px" height="50px" class="avatar-image rounded-circle" src="<?php echo "../../".$profile_pic; ?>" alt="Image">
                        <?php } else {?>
                            <div class="px-4">
                                <div class="avatar-circle">
                                    <span class="initials" ><?php  echo $initials; ?></span>
                                </div>
                            </div>
                        <?php }?>
                    </td>
                    <td class="text-center align-middle"><?php echo $student_id;?></td>
                    <td class="text-start align-middle"><?php echo $full_name;?></td>
                    <td class="text-start align-middle"><?php echo $department;?></td>
                    <td class="text-center align-middle"><?php echo $year;?></td>
                    <td class="text-center align-middle"><?php echo $position_name;?></td>
                    <td class="text-center align-middle"><?php echo $party_name;?></td>
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
