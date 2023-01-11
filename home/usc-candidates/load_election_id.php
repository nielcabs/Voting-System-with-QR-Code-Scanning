<?php
    $url    = "../../";
    if (!isset($_SESSION)) { 
        session_start(); 
    } 
    $user_name      = $_SESSION['E_Voting_System'];
    $user_fname     = $_SESSION['fullname'];
    include_once($url.'connection/mysql_connect.php');


    $action             = $_POST["action"];
    $election_id        = $_POST["election_id"];

    if ($action == 'Add') {
        $query = "AND status ='N'" ?? '';
    } else if ($action == 'Update') {
        $query = "AND status IN ('In-Progress','Completed','N')" ?? ''; 
    }


    if ($action != NULL) {
        
        $sql        = "SELECT a.election_id, a.election_name, b.description
                        FROM tbl_election a
                        LEFT JOIN tbl_election_type b
                        ON a.election_name = b.election_type
                        WHERE election_name = 'USC' $query";
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
