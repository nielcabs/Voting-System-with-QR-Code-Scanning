<?php

    $url    = "../../";
    if (!isset($_SESSION)) { 
        session_start(); 
    } 
    $user_name      = $_SESSION['E_Voting_System'];
    $user_fname     = $_SESSION['fullname'];
    include_once($url.'connection/mysql_connect.php');


    $del_rec_id             = $_POST['rec_id'];
    $del_username_id        = $_POST['username_id'];
   

    $query  = "SELECT rec_id, username_id, first_name, middle_name, last_name, email, dept_id, year,
                    access_rights, vote_status, active, chg_password, date_added, date_updated,
                    last_login
                FROM tbl_users
                WHERE username_id ='$del_username_id' AND rec_id ='$del_rec_id'";
    $result = mysqli_query($db,$query);
    $row    = mysqli_fetch_array($result);
    $count_row = mysqli_num_rows($result);


    if($count_row > 0){


        $delete_imp = "DELETE FROM tbl_users 
                       WHERE username_id ='$del_username_id' AND rec_id ='$del_rec_id'";
        $result_imp = mysqli_query($db,$delete_imp);


     
        echo "Deleted Successfully!";

    }else {

      echo "No record/s found."; 
   }

    mysqli_close($db);   
?>