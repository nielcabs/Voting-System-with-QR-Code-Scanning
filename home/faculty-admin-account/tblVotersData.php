
<?php include_once('../../connection/mysql_connect.php'); ?>

<div class="table-responsive">
    
    <table class="table table-bordered table-hover table-light tableDark table-sm" id="dttables_user">
        <thead class="nowrap">
            <tr class="table-secondary text-center th-fs"> 
                <th class="text-center align-middle" width="3%">ID</th>
                <th class="text-center" width="13%">Faculty ID No.</th>
                <th class="text-center" width="34%">Student Name</th>
                <th class="text-center" width="27%">Department</th>
                <!-- <th class="text-center" width="10%">Active Voter?</th> -->
                <th class="text-center" width="23%">Action</th>
            </tr>
        </thead>
        <tbody class="">
            <?php

            $sql_get = "SELECT a.rec_id, a.username_id, a.first_name, a.middle_name, a.last_name, a.email, a.dept_id, a.year,
                                a.access_rights, a.vote_status, a.active, a.chg_password, a.date_added, a.date_updated,
                                a.last_login, b.department, a.user_password
                        FROM tbl_users a
                        LEFT JOIN tbl_department b
                        ON a.dept_id = b.dept_id
                        WHERE a.access_rights='faculty_admin'
                        ORDER BY a.last_name";
            $result  = mysqli_query($db,$sql_get) or die(mysqli_error($db));
            $cnt = 1;
            while($row 	= mysqli_fetch_assoc($result)){

                $rec_id                 = $row['rec_id'];
                $username_id            = $row['username_id'];
                $first_name             = $row['first_name'];
                $middle_name            = $row['middle_name'];
                $last_name              = $row['last_name'];
                $email                  = $row['email'];
                $deptid                 = $row['dept_id'];
                $department             = $row['department'];
                $access_rights          = $row['access_rights'];
                $year                   = $row['year'];
                $vote_status            = $row['vote_status'];
                $active                 = $row['active'];
                $chg_password           = $row['chg_password'];
                $date_added             = $row['date_added'];
                $date_updated           = $row['date_updated'];
                $last_login             = $row['last_login'];
                $user_password          = $row['user_password'];

                $full_name              = $last_name.', '.$first_name.' '.$middle_name;


                $data_val               = $rec_id."|".$username_id."|".$user_password."|".$first_name."|".$middle_name."|".$last_name."|".$email."|".$deptid."|".$year;
                
                $data_del               = $rec_id."|".$username_id;

                $data_active            = $rec_id."|".$username_id."|".$active;

                //if($active =="Y") { echo "fa-check-circle";}else{ echo "fa-times-circle";}
            ?>  
                <tr>
                    <td class="text-center align-middle"><?php echo $cnt; ?></td>
                    <td class="text-center align-middle"><?php echo $username_id;?></td>
                    <td class="text-start align-middle"><?php echo $full_name;?></td>
                    <td class="text-start align-middle"><?php echo $department;?></td>
                    <!-- <td class="text-center align-middle">
                        <button data-active="<?php echo $data_active; ?>" id="" type="button" class="btn <?php  if($active =="Y") { echo "btn-success";}else{ echo "btn-danger";} ?> btn-sm act_deact"><i class="fas <?php  if($active =="Y") { echo "fa-check-circle";}else{ echo "fa-times-circle";} ?>"></i></button>
                    </td> -->
                    <td class="text-center align-middle">
                        <button data-update="<?php echo $data_val; ?>" id="" type="button" class="btn btn-success btn-sm myModalUpdate" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to Edit"><i class="fas fa-edit"></i></button>
                        <button data-active="<?php echo $data_active; ?>" id="" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php  if($active =="Y") { echo "Deactivate Account";}else{ echo "Activate Account";} ?>"
                                class="btn <?php  if($active =="Y") { echo "btn-success";}else{ echo "btn-danger";} ?> btn-sm act_deact">
                                <i class="fas <?php  if($active =="Y") { echo "fa-check-circle";}else{ echo "fa-times-circle";} ?>"></i>
                        </button>
                        <button data-untag="<?php echo $data_active; ?>" id="" type="button" class="btn btn-warning btn-sm untag" data-bs-toggle="tooltip" data-bs-placement="top" title="Untag as Admin"><i class="fas fa-user-times "></i></button>
                        <!-- <button data-delete="<?php echo $data_del; ?>" id="" type="button" class="btn btn-primary btn-sm tag_to_vote"><i class="fas xfa-trash ">&nbsp;</i>Tag to Vote</button> -->
                        <!-- <button data-delete="<?php echo $data_del; ?>" id="" type="button" class="btn btn-danger btn-sm delete_user"><i class="fas fa-trash "></i></button> -->
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
