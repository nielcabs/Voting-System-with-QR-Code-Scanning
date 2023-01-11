<?php

    $url        = "../";
    include_once($url.'connection/mysql_connect.php');
	
    $uname          = mysqli_real_escape_string($db,$_POST['user_name']);
    $upass          = mysqli_real_escape_string($db,$_POST['old_pass']);
    $upassnew       = mysqli_real_escape_string($db,$_POST['new_pass']);
    $upassconfirm   = mysqli_real_escape_string($db,$_POST['confirm_pass']);
	
    $query  ="SELECT *
              FROM tbl_users
              WHERE username_id='$uname' 
              AND user_password = OLD_PASSWORD('$upass')";
    $result = mysqli_query($db, $query);
    $row 	= mysqli_fetch_assoc($result);

    if ($row) {	 
                    
                    

        $sqlUpdatePass="UPDATE tbl_users
                        SET user_password = OLD_PASSWORD('$upassnew'), chg_password = 'N', change_date = NOW(), auth_login = 'N', code = ''
                        WHERE username_id = '$uname' and user_password = OLD_PASSWORD('$upass')";
        $result = mysqli_query($db,$sqlUpdatePass);	
        
        if (!isset($_SESSION)) { 
            session_start(); 
        } 
        $_SESSION['chg_password']      = "N";
        echo "You have successfully changed your password.";

    } else {
        echo "You have entered an Invalid Password";		 	
    }
    
    mysqli_close($db);  
?>

