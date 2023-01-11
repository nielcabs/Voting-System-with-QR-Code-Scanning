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
                <th class="text-center align-middle" width="3%">#</th>
                <th class="text-center" width="15%">Party Name</th>
                <th class="text-center" width="15%">Election Type</th>
                <th class="text-center" width="25%">Department</th>
                <th class="text-center" width="25%">Election ID</th>
                <th class="text-center" width="10%">Action</th>
            </tr>
        </thead>
        <tbody class="">
            <?php

            if($access_rights =='std_admin') {
                $query = "WHERE election_type IN ('USC','LDSC')";
            }else if($access_rights =='faculty_admin') {
                $query = "WHERE election_type ='FCE'";
            } else if($access_rights =='SUPERADMIN') {
                $query = "WHERE election_type IN ('USC','LDSC','FCE')";
            }

        

            $sql_get = "SELECT rec_id, party_name, election_type, dept_id, election_id, election_status
                        FROM tbl_party
                        $query
                        ORDER BY rec_id DESC";
            $result  = mysqli_query($db,$sql_get) or die(mysqli_error($db));
            $cnt = 1;
            while($row 	= mysqli_fetch_assoc($result)){

                $rec_id                 = $row['rec_id'];
                $party_name             = $row['party_name'];
                $election_type          = $row['election_type'];
                $dept_id                = $row['dept_id'];
                $election_id            = $row['election_id'];
                $election_status        = $row['election_status'];

                if ($election_type =="USC") {
                    $election_name = "University Student Council";
                } else if ($election_type =="FCE"){
                    $election_name = "Faculty Election";
                } else if ($election_type =="LDSC"){
                    $election_name = "Localized Student Council";
                }

                $get = "SELECT rec_id, dept_id, department
                        FROM tbl_department WHERE dept_id ='$dept_id'";
                $res = mysqli_query($db, $get);
                $row1 = mysqli_fetch_assoc($res);

                $dept_name      = $row1['department'] ?? '';
        
            
                $data_val       = $rec_id."|".$party_name."|".$election_type."|".$dept_id."|".$election_status;
                
            ?>  
                <tr>
                    <td class="text-center align-middle"><?php echo $cnt; ?></td>
                    <td class="text-left align-middle"><?php echo $party_name;?></td>
                    <td class="text-center align-middle"><?php echo $election_name;?></td>
                    <td class="text-start align-middle"><?php echo $dept_name;?></td>
                    <td class="text-start align-middle"><?php echo $election_id.' / '.$election_status;?></td>
                    <td class="text-center align-middle">
                        <button data-update="<?php echo $data_val; ?>" id="" type="button" class="btn btn-sm btn-success myModalUpdate" 
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Click to Edit"
                                ><i class="fas fa-edit fs-5"></i>
                        </button>
                        <button data-delete="<?php echo $data_val; ?>" id="" type="button" class="btn btn-danger btn-sm delete_party"><i class="fas fa-trash "></i></button>
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
