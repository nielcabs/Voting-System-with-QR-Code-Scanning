<?php

    $url    = "../../";
    if (!isset($_SESSION)) { 
        session_start(); 
    } 
    $user_name      = $_SESSION['E_Voting_System'];
    $user_fname     = $_SESSION['fullname'];
    include_once($url.'connection/mysql_connect.php');


    $del_rec_id             = $_POST['rec_id'];
   

    $query  = "SELECT *
                FROM tbl_party
                WHERE rec_id ='$del_rec_id'";
    $result = mysqli_query($db,$query);
    $row    = mysqli_fetch_array($result);
    $count_row = mysqli_num_rows($result);


    if($count_row > 0){


        $delete_imp = "DELETE FROM tbl_party 
                       WHERE rec_id ='$del_rec_id'";
        $result_imp = mysqli_query($db,$delete_imp);


     
        echo "Deleted Successfully!";

    }else {

      echo "No record/s found."; 
   }

    mysqli_close($db);   
?>