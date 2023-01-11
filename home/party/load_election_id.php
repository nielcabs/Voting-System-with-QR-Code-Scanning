<?php
    $url    = "../../";
    if (!isset($_SESSION)) { 
        session_start(); 
    } 
    $user_name      = $_SESSION['E_Voting_System'];
    $user_fname     = $_SESSION['fullname'];
    include_once($url.'connection/mysql_connect.php');


    $election_type      = $_POST["election_type"] ?? '';
    $dept_id            = $_POST["dept_id"] ?? '';

    if ($election_type =='LDSC' && $dept_id != Null) {
        $query = "WHERE election_name = '$election_type' AND a.status ='N' AND department ='$dept_id'" ?? '';
    } else if ($election_type =='USC') {
        $query = "WHERE election_name = '$election_type' AND a.status ='N'" ?? ''; 
    } else {
        $query = " WHERE election_name = ''" ?? ''; 
    }


    if ($election_type != NULL) {
        
        $sql        = "SELECT a.election_id, a.election_name, b.description
                        FROM tbl_election a
                        LEFT JOIN tbl_election_type b
                        ON a.election_name = b.election_type
                        $query";
        $result     = mysqli_query($db, $sql);   
        $rowCount   = mysqli_num_rows($result);
        
        //State option list
        if ($rowCount > 0) {
            echo '<option value="" selected disabled>Select Election</option>';
            while ($row = mysqli_fetch_assoc($result)) { 

                if ($election_id == $row['election_id']) {
                    $xslctd = 'selected';
                } else {
                    $xslctd = '';
                }

                echo '<option value="'.$row['election_id'].'" '.$xslctd.'>'.''.$row['election_id'].' - '.$row['description'].'</option>';
            }
        } else {
            echo '<option value="">No Election Available</option>';
        }
    }

    mysqli_close($db);
?>
