<?php
    $url    = "../../";
    if (!isset($_SESSION)) { 
        session_start(); 
    } 
    $user_name      = $_SESSION['E_Voting_System'];
    $user_fname     = $_SESSION['fullname'];
    include_once($url.'connection/mysql_connect.php');


    $action             = $_POST["action"] ?? '';
    $election_id        = $_POST["election_id"] ?? '';
    $party_name         = $_POST["party_name"] ?? '';
    $position           = $_POST["position"] ?? '';
    $student_id         = $_POST["student_id"] ?? '';

    if ($action == 'Add') {
        //$query = "WHERE election_id = '$election_id' AND election_status = 'N'" ?? '';

        $sql1   = "SELECT * 
                   FROM tbl_candidates
                   WHERE election_id = '$election_id' AND position='$position'";
        $res1   = mysqli_query($db, $sql1);
        $row1   = mysqli_fetch_assoc($res1);
        $cnt    = mysqli_num_rows($res1) ?? '';

        $cand_pt_name = $row1['party_name'];

        if ($cnt > 0) {
            $query = "WHERE election_id = '$election_id' AND election_status = 'N' AND party_name NOT IN (SELECT party_name 
                                                                                                            FROM tbl_candidates
                                                                                                            WHERE election_id = '$election_id' AND position='$position')" ?? '';
        } else {
            $query = "WHERE election_id = '$election_id' AND election_status = 'N'" ?? '';
        }


    } else if ($action == 'Update') {
        //$query = "WHERE election_id = '$election_id'" ?? ''; 

        $sql1   = "SELECT * 
                   FROM tbl_candidates
                   WHERE election_id = '$election_id' AND position='$position'";
        $res1   = mysqli_query($db, $sql1);
        $row1   = mysqli_fetch_assoc($res1);
        $cnt    = mysqli_num_rows($res1) ?? '';

        $cand_pt_name = $row1['party_name'];

        if ($cnt > 0) {
            $query = "WHERE election_id = '$election_id' AND party_name IN (SELECT party_name 
                                                                            FROM tbl_candidates
                                                                            WHERE election_id = '$election_id' AND position='$position' and student_id='$student_id'
                                                                            UNION ALL
                                                                            SELECT party_name
                                                                            FROM tbl_party
                                                                            WHERE election_id = '$election_id' AND election_status = 'N' AND party_name NOT IN (SELECT party_name 
                                                                                                            FROM tbl_candidates
                                                                                                            WHERE election_id = '$election_id'  and student_id!='$student_id'
                                                                                                            AND position='$position'))" ?? '';
            //$party_name = $cand_pt_name;
        } else {
            $query = "WHERE election_id = '$election_id'" ?? '';
        }
    }

  


    if ($election_id != NULL) {
        
        $sql        = "SELECT *
                        FROM tbl_party
                        $query";
        $result     = mysqli_query($db, $sql);   
        $rowCount   = mysqli_num_rows($result);
        
        //State option list
        if ($rowCount > 0) {
            echo '<option value="" selected disabled>Select Party</option>';
            while ($row = mysqli_fetch_assoc($result)) { 

                if ($party_name == $row['party_name']) {
                    $xslctd = 'selected';
                } else {
                    $xslctd = '';
                }

                echo '<option value="'.$row['party_name'].'" '.$xslctd.'>'.$row['party_name'].'</option>';
            }
        } else {
            echo '<option value="">No Party Available</option>';
        }
    }

    mysqli_close($db);
?>
