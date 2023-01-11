<?php
    $url        = "../../";
    if (!isset($_SESSION)) { 
        session_start(); 
    } 
    include_once($url.'connection/mysql_connect.php');

    $username_id        = $_SESSION['username_id'];
    $id_election            = $_POST['id_election'];

    if (!isset($_SESSION['E_Voting_System'])) {
        echo "Relogin|";
    } else {


        $save_rec1 = "INSERT INTO tbl_voter_status 
                             (student_id_voter, election_id, status_vote, date_added)					 
                      VALUES ('$username_id', '$id_election', 'A', NOW())";
        $result1     = mysqli_query($db, $save_rec1);

        if($result1){
            echo "Saved|";
        }

    }

?>