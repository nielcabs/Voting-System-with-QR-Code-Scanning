<?php

    $url    = "../../";
    if (!isset($_SESSION)) { 
        session_start(); 
    } 
    $user_name      = $_SESSION['E_Voting_System'];
    $user_fname     = $_SESSION['fullname'];
    include_once($url.'connection/mysql_connect.php');


    $upt_rec_id             = $_POST['rec_id'];
    $upt_election_id        = $_POST['election_id'];
    $upt_status             = $_POST['status'];


   

    $query  = "SELECT *
               FROM tbl_election
               WHERE election_id ='$upt_election_id' AND rec_id ='$upt_rec_id'";
    $result = mysqli_query($db,$query);
    $row    = mysqli_fetch_array($result);
    $count_row = mysqli_num_rows($result);


    if($count_row > 0){
        date_default_timezone_set("Asia/Hong_Kong");
        $date_now = date('m/d/Y h:i A');

        $upt = "UPDATE tbl_election 
                SET status = 'Completed'
                WHERE election_id ='$upt_election_id' AND rec_id ='$upt_rec_id'";
        $result_imp = mysqli_query($db,$upt);

        $upta = "UPDATE tbl_candidates 
                SET election_status = 'Completed'
                WHERE election_id = '$upt_election_id'";
        $resulta = mysqli_query($db,$upta);

        $uptb = "UPDATE tbl_party 
                 SET election_status = 'Completed'
                 WHERE election_id = '$upt_election_id'";
        $resultb = mysqli_query($db,$uptb);

        echo "Successfully Update";

    } else {

      echo "No record/s found."; 
    }

    mysqli_close($db);   
?>