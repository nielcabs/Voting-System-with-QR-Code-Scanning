<?php
    $url    = "../../";
    if (!isset($_SESSION)) { 
        session_start(); 
    } 
    date_default_timezone_set("Asia/Hong_Kong");
    $user_name      = $_SESSION['E_Voting_System'];
    $user_fname     = $_SESSION['fullname'];
    include_once($url.'connection/mysql_connect.php');

    if (!isset($_SESSION['E_Voting_System'])) {
        echo "Relogin";
    } else {

        $user_pass  = mysqli_real_escape_string($db,$_POST['user_pass']);

        $sql        = "SELECT * 
                       FROM tbl_users 
                       WHERE username_id = '$user_name' 
                       AND user_password = OLD_PASSWORD('$user_pass')";
        $result     = mysqli_query($db,$sql);
        $row        = mysqli_fetch_assoc($result);
        $count      = mysqli_num_rows($result);	

        if ($count == 1) {
            echo "PassMatch";
        } else {
            echo "WrongPass";
        }
     

    }

	mysqli_close($db); 		
?>