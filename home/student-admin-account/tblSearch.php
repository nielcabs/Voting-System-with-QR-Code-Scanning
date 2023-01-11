
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
            <th class="text-center" width="10%">Section</th>
            </tr>
        </thead>
        <tbody class="">
            <?php

            $sql_get = "SELECT a.rec_id, a.username_id, a.first_name, a.middle_name, a.last_name, a.email, a.dept_id, a.year,
                                a.access_rights, a.vote_status, a.active, a.chg_password, a.date_added, a.date_updated,
                                a.last_login, b.department, a.user_password, a.std_class, a.section
                        FROM tbl_users a
                        LEFT JOIN tbl_department b
                        ON a.dept_id = b.dept_id
                        WHERE a.access_rights='std_voter'
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
                $std_class              = $row['std_class'];
                $section                = $row['section'];

                if($year == "1"){
                    $year_lbl = "1st Yr.";
                }else if($year == "2"){
                    $year_lbl = "2nd Yr.";
                }else if($year == "3"){
                    $year_lbl = "3rd Yr.";
                }else if($year == "4"){
                    $year_lbl = "4th Yr.";
                }else if($year == "11"){
                    $year_lbl = "Grade 11";
                }else if($year == "12"){
                    $year_lbl = "Grade 12";
                }

                $full_name              = $last_name.', '.$first_name.' '.$middle_name;


                $data_val               = $rec_id."|".$username_id."|".$user_password."|".$first_name."|".$middle_name."|".$last_name."|".$email."|".$deptid."|".$year."|".$std_class."|".$section;;
                
                $data_del               = $rec_id."|".$username_id;

                $data_active            = $rec_id."|".$username_id."|".$active;

                //if($active =="Y") { echo "fa-check-circle";}else{ echo "fa-times-circle";}
            ?>  
                <tr class="myModalUpdate2" data-update="<?php echo $data_val; ?>">
                    <td class="text-center align-middle"><?php echo $cnt; ?></td>
                    <td class="text-center align-middle"><?php echo $username_id;?></td>
                    <td class="text-start align-middle"><?php echo $full_name;?></td>
                    <td class="text-start align-middle"><?php echo $department;?></td>
                    <td class="text-center align-middle"><?php echo $year_lbl;?></td>
                    <td class="text-center align-middle"><?php echo $section;?></td>
            
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
          "lengthMenu": [[5, 25, 50, 100, -1], [ 10, 25, 50, 100, "All"]]
        });
    });
</script>

<script>
 

</script>