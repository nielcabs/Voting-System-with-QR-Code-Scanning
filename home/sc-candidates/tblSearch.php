
<?php include_once('../../connection/mysql_connect.php'); ?>

<div class="table-responsive">
    
    <table class="table table-striped table-bordered table-sm table-hover tableDark" id="dttables_user2">
        <thead class="nowrap">
            <tr class="table-primary text-center th-fs"> 
            <th class="text-center align-middle" width="3%">#</th>
            <th class="text-center" width="15%">StudentID / Username</th>
            <th class="text-center" width="39%">Student Name</th>
            <th class="text-center" width="33%">Department</th>
            <th class="text-center" width="10%">Year</th>
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
                        WHERE a.access_rights IN ('std_voter') AND a.username_id NOT IN (SELECT student_id FROM tbl_candidates  WHERE election_status IN ('N','In-Progress'))
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
                <tr class="myModalUpdate2" data-update="<?php echo $data_val; ?>">
                    <td class="text-center align-middle"><?php echo $cnt; ?></td>
                    <td class="text-center align-middle"><?php echo $username_id;?></td>
                    <td class="text-start align-middle"><?php echo $full_name;?></td>
                    <td class="text-start align-middle"><?php echo $department;?></td>
                    <td class="text-center align-middle"><?php echo $year;?></td>
            
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
        $('#dttables_user2').DataTable({
            "lengthMenu": [[5, 25, 50, 100, -1], [ 10, 25, 50, 100, "All"]],
            "language": {
                // show when no record found in a table...
                "emptyTable": '<p class="block text-center fw-bold"><i class="fa fa-exclamation-triangle" style="color: #C49F47;">&nbsp;</i> No matching records found or The person is already running for a position <br> Kindly Check!.</p>',
                // shown when no matching row found in filtering...
                "zeroRecords": '<p class="block text-center fw-bold"><i class="fa fa-exclamation-triangle" style="color: #C49F47;">&nbsp;</i>No matching records found or The person is already running for a position<br> Kindly Check!. </p>'
            }
        });
    });
</script>

<script>
 

</script>