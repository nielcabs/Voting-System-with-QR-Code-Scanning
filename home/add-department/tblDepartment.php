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
                <th class="text-center" width="17%">Department ID</th>
                <th class="text-center" width="25%">Department Name</th>
                <th class="text-center" width="20%">Action</th>
            </tr>
        </thead>
        <tbody class="">
            <?php

        

            $sql_get = "SELECT rec_id, dept_id, department
                        FROM tbl_department 
                        ORDER BY rec_id";
            $result  = mysqli_query($db,$sql_get) or die(mysqli_error($db));
            $cnt = 1;
            while($row 	= mysqli_fetch_assoc($result)){

                $rec_id                 = $row['rec_id'];
                $dept_id                = $row['dept_id'];
                $department             = $row['department'];
            
                $data_val               = $rec_id."|".$dept_id."|".$department;
                
            ?>  
                <tr>
                    <td class="text-center align-middle"><?php echo $cnt; ?></td>
                    <td class="text-start align-middle"><?php echo $dept_id;?></td>
                    <td class="text-start align-middle"><?php echo $department;?></td>
                    <td class="text-center align-middle">
                        <button data-update="<?php echo $data_val; ?>" id="" type="button" class="btn btn-sm btn-success myModalUpdate" 
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Click to Edit"
                                ><i class="fas fa-edit fs-5"></i>
                        </button>
                        <button data-delete="<?php echo $data_val; ?>" id="" type="button" class="btn btn-danger btn-sm delete_dept"><i class="fas fa-trash "></i></button>
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
