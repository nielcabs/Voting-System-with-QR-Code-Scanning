<?php

    $url    = "../../";
    if (!isset($_SESSION)) { 
        session_start(); 
    } 
    $user_name      = $_SESSION['E_Voting_System'];
    $user_fname     = $_SESSION['fullname'];
    include_once($url.'connection/mysql_connect.php');


    $upt_rec_id             = $_POST['rec_id'];
    $upt_username_id        = $_POST['username_id'];
    $upt_active             = $_POST['active'];

    if ($upt_active =="Y") {
        $active ="N";
    } else {
        $active ="Y";
    }
   

    $query  = "SELECT rec_id, username_id, first_name, middle_name, last_name, email, dept_id, year,
                    access_rights, vote_status, active, chg_password, date_added, date_updated,
                    last_login
                FROM tbl_users
                WHERE username_id ='$upt_username_id' AND rec_id ='$upt_rec_id'";
    $result = mysqli_query($db,$query);
    $row    = mysqli_fetch_array($result);
    $count_row = mysqli_num_rows($result);


    if($count_row > 0){


        $upt = "UPDATE tbl_users 
                       SET active = '$active'
                       WHERE username_id ='$upt_username_id' AND rec_id ='$upt_rec_id'";
        $result_imp = mysqli_query($db,$upt);


     
        echo "Successfully Update";

    } else {

      echo "No record/s found."; 
    }

    mysqli_close($db);   
?>