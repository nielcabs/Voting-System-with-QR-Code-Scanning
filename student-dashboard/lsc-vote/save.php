<?php
    $url        = "../../";
    if (!isset($_SESSION)) { 
        session_start(); 
    } 
    include_once($url.'connection/mysql_connect.php');

    $username_id        = $_SESSION['username_id'];
    $access_rights      = $_SESSION['access_rights'];
    $fullname           = $_SESSION['fullname'];
    $department         = $_SESSION['dept_id'];
    $chg_password       = $_SESSION['chg_password'];
    $first_name         = $_SESSION['first_name'];
    $middle_name        = $_SESSION['middle_name'] ;
    $last_name          = $_SESSION['last_name'];
    $dept_id            = $_SESSION['dept_id'] ;
    $email              = $_SESSION['email'];

    $id_election            = $_POST['id_election'];

    $selected_recid         = $_POST['selected_recid'];
    $arry_recid             = explode(',', $selected_recid);

    $selected_stid          = $_POST['selected_stid'];
    $arry_candid            = explode(',', $selected_stid);

    $selected_pos           = $_POST['selected_pos'];
    $arry_position          = explode(',', $selected_pos);

    $selected_elecid        = $_POST['selected_elecid'];
    $arry_elecid            = explode(',', $selected_elecid);

    if (!isset($_SESSION['E_Voting_System'])) {
        echo "Relogin|";
    } else {

        for ($x=0; $x < count($arry_recid); $x++){


            $get_vote       = "SELECT ((vote_count)+1) vote_cnt 
                               FROM tbl_candidates
                               WHERE rec_id='$arry_recid[$x]'";
            $res_vote       = mysqli_query($db, $get_vote)or die("Error description: ". mysqli_error($db));	
            $row_vote       = mysqli_fetch_assoc($res_vote);
            
            $vote_count     = ($row_vote["vote_cnt"]!='') ? $row_vote["vote_cnt"] : "1";

            $query  = "UPDATE tbl_candidates
                       SET vote_count='$vote_count'
                       WHERE rec_id='$arry_recid[$x]'";
            $result = mysqli_query($db,$query); 

            $save_rec = "INSERT INTO tbl_votes (student_id_voter, candidate_id, candidate_pos, election_id, date_added)					 
                                            VALUES ('$username_id', '$arry_recid[$x]', '$arry_position[$x]', '$arry_elecid[$x]', NOW())";
            $result     = mysqli_query($db, $save_rec);

        }  

        $save_rec1 = "INSERT INTO tbl_voter_status 
                             (student_id_voter, election_id, status_vote, date_added)					 
                      VALUES ('$username_id', '$id_election', 'Y', NOW())";
        $result1     = mysqli_query($db, $save_rec1);

        if($result){
            echo "Saved|".$username_id.'|'.$id_election;
        }

    }

?>