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
               FROM dhvsuevo_voting.tbl_election
               WHERE election_id ='$upt_election_id' AND rec_id ='$upt_rec_id'";
    $result = mysqli_query($db,$query);
    $row    = mysqli_fetch_array($result);
    $count_row = mysqli_num_rows($result);


    if($count_row > 0){
        date_default_timezone_set("Asia/Hong_Kong");
        $date_now = date('m/d/Y h:i A');
        $upt = "UPDATE dhvsuevo_voting.tbl_election 
                SET status = 'Completed', date_end = '$date_now' 
                WHERE election_id ='$upt_election_id' AND rec_id ='$upt_rec_id'";
        $result_imp = mysqli_query($db,$upt);

        echo "Successfully Update";

    } else {

      echo "No record/s found."; 
    }

    mysqli_close($db);   
?>