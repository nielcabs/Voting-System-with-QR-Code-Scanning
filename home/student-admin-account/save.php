<?php
    $url    = "../../";
    if (!isset($_SESSION)) { 
        session_start(); 
    } 
    $user_name      = $_SESSION['E_Voting_System'];
    $user_fname     = $_SESSION['fullname'];
    include_once($url.'connection/mysql_connect.php');

    if (!isset($_SESSION['E_Voting_System'])) {
        echo "Relogin|";
    } else {

        $rec_id             = mysqli_real_escape_string($db,$_POST['rec_id']);
        $studentid          = mysqli_real_escape_string($db,$_POST['username_id']);
        $user_password      = mysqli_real_escape_string($db,$_POST['user_password']);
        $first_name         = mysqli_real_escape_string($db,$_POST['first_name']);
        $middle_name        = mysqli_real_escape_string($db,$_POST['middle_name']);
        $last_name          = mysqli_real_escape_string($db,$_POST['last_name']);
        $email              = mysqli_real_escape_string($db,$_POST['email']);
        $dept_id            = mysqli_real_escape_string($db,$_POST['department']);
        $year  	            = mysqli_real_escape_string($db,$_POST['year']);
        $action             = mysqli_real_escape_string($db,$_POST['action']);
        $new_password       = mysqli_real_escape_string($db,$_POST['new_password']);
        // $std_class          = mysqli_real_escape_string($db,$_POST['std_class']);
        $section            = mysqli_real_escape_string($db,$_POST['section']);

        if($rec_id == '' && $action =='Add'){
           
            //Check User if already exist	
            $sql_chk		= "SELECT rec_id, username_id, first_name, middle_name, last_name, email, dept_id, year,
                                          access_rights, vote_status, active, chg_password, date_added, date_updated,
                                          last_login
                               FROM tbl_users
                               WHERE username_id ='$studentid'";	
            $res_chk        = mysqli_query($db, $sql_chk) or die (mysqli_error($db));
            $row        	= mysqli_fetch_assoc($res_chk);
            $row_cnt        = mysqli_num_rows($res_chk);	
            $uid            = $row['username_id'] ?? null;

            //Check email if exist
            $sql_em		    = "SELECT *
                               FROM tbl_users
                               WHERE email = '$email'";	
            $res_em        = mysqli_query($db, $sql_em) or die (mysqli_error($db));
            $row_cnt_em     = mysqli_num_rows($res_em);	

            if ($row_cnt > 0) {
                echo "exist|".$uid;    
            } else if ($row_cnt_em > 0) {
                echo "email_exist|";    
            } else {   

                $save_rec = "INSERT INTO tbl_users (username_id, user_password, first_name, middle_name, last_name, tag_to_vote, section,
                                                           email, dept_id, year, access_rights, chg_password, added_by, date_added)					 
                             VALUES ('$studentid', OLD_PASSWORD('$user_password'), '$first_name', '$middle_name', '$last_name', 'Y', '$std_class', '$section',
                                     '$email', '$dept_id', '$year', 'std_admin', 'Y', '$user_name', NOW())";
                $result     = mysqli_query($db, $save_rec);
    
                echo "Saved|";
        
            }

        } else if ($action =="Update" && $rec_id !='') {

            //Check User if already exist	
            $sql_chk		= "SELECT *
                               FROM tbl_users
                               WHERE rec_id != '$rec_id' AND username_id ='$studentid'";	
            $res_chk        = mysqli_query($db, $sql_chk) or die (mysqli_error($db));
            $row        	= mysqli_fetch_assoc($res_chk);
            $row_cnt        = mysqli_num_rows($res_chk);	
            $uid            = $row['username_id'] ?? null;
 
            if ($row_cnt > 0) {
                echo "exist|".$sql_chk;  
            } else {  

                if($new_password !=''){
                    $update_pass = ",user_password =  OLD_PASSWORD('$new_password')";
                } else {
                    $update_pass = "";
                }

                $sql_update  = "UPDATE tbl_users
                                SET username_id = '$studentid', first_name = '$first_name', middle_name = '$middle_name', last_name = '$last_name',
                                    email = '$email', dept_id = '$dept_id', year = '$year', section = '$section',
                                    updated_by = '$user_fname', date_updated = NOW()  $update_pass
                                WHERE rec_id='$rec_id'";
                $result      = mysqli_query($db, $sql_update);

                echo "Updated|".$sql_update;
        
            }

            
        } else if ($action =="Tag_Update" && $rec_id !='') {

            //Check User if already exist	
            $sql_chk		= "SELECT *
                               FROM tbl_users
                               WHERE rec_id != '$rec_id' AND username_id ='$studentid'";	
            $res_chk        = mysqli_query($db, $sql_chk) or die (mysqli_error($db));
            $row        	= mysqli_fetch_assoc($res_chk);
            $row_cnt        = mysqli_num_rows($res_chk);	
            $uid            = $row['username_id'] ?? null;
 
            if ($row_cnt > 0) {
                echo "exist|".$sql_chk;  
            } else {  

                if($new_password !=''){
                    $update_pass = ",user_password =  OLD_PASSWORD('$new_password')";
                } else {
                    $update_pass = "";
                }

                $sql_update  = "UPDATE tbl_users
                                SET access_rights = 'std_admin'
                                WHERE rec_id='$rec_id'";
                $result      = mysqli_query($db, $sql_update);

                echo "Updated|".$sql_update;
        
            }

            
        }else {
            echo "errorSaving|";
        }

     

    }

	mysqli_close($db); 		
?>