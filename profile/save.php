<?php

    if (!isset($_SESSION)) { 
        session_start(); 
    } 
    $user_name      = $_SESSION['E_Voting_System'];
    $user_fname     = $_SESSION['fullname'];

    $url        = "../";
    include_once($url.'connection/mysql_connect.php');

    if (!isset($_SESSION['E_Voting_System'])) {
        echo "Relogin|";
    } else {

        $username_id        = mysqli_real_escape_string($db,$_REQUEST['username_id']);
        $first_name         = mysqli_real_escape_string($db,$_REQUEST['first_name']);
        $middle_name        = mysqli_real_escape_string($db,$_REQUEST['middle_name']);
        $last_name          = mysqli_real_escape_string($db,$_REQUEST['last_name']);
        $department         = mysqli_real_escape_string($db,$_REQUEST['department']);
        $email  	            = mysqli_real_escape_string($db,$_REQUEST['email']);
        $target_dir         = '../profile_pic/';
        $target_dir1        = 'profile_pic';

        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        if($_FILES["upload_img"]["name"] ?? null !=""){
            $upload_img = $target_dir1 .'/'.$username_id.'-'. $_FILES["upload_img"]["name"];
            move_uploaded_file($_FILES["upload_img"]["tmp_name"],$target_dir .'/'. $username_id.'-'.$_FILES["upload_img"]["name"]);
        } 

        //Check Voter if already exist	
        $sql_chk1		= "SELECT *
                            FROM tbl_users
                            WHERE username_id ='$username_id'";	
        $res_chk1       = mysqli_query($db, $sql_chk1) or die (mysqli_error($db));
        $row1        	= mysqli_fetch_assoc($res_chk1);
        $row_cnt1       = mysqli_num_rows($res_chk1);	

        if($row_cnt1 ==0){
            echo "notexist|";    
        } else {

            $with_image = "";
            if ($_FILES["upload_img"]["name"] ?? null !="") {
                $with_image = ",profile_pic = '$upload_img'";
            }

            $sql_update  = "UPDATE tbl_users
                            SET first_name = '$first_name', middle_name = '$middle_name', last_name = '$last_name', email = '$email',
                                updated_by = '$user_fname', date_updated = NOW() $with_image
                            WHERE username_id='$username_id'";
            $result      = mysqli_query($db, $sql_update);

            echo "Saved|";
    
        } 

     

    }

	mysqli_close($db); 	
?>

