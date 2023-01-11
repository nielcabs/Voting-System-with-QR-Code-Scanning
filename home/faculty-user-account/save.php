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
        $old_studentid      = mysqli_real_escape_string($db,$_POST['old_username_id']);
        $user_password      = mysqli_real_escape_string($db,$_POST['user_password']);
        $first_name         = mysqli_real_escape_string($db,$_POST['first_name']);
        $middle_name        = mysqli_real_escape_string($db,$_POST['middle_name']);
        $last_name          = mysqli_real_escape_string($db,$_POST['last_name']);
        $email              = mysqli_real_escape_string($db,$_POST['email']);
        $dept_id            = mysqli_real_escape_string($db,$_POST['department']);
        $action             = mysqli_real_escape_string($db,$_POST['action']);
        $new_password       = mysqli_real_escape_string($db,$_POST['new_password']);

        if($rec_id == '' && $action =='Add'){
           
            //Check User if already exist	
            $sql_chk		= "SELECT rec_id, username_id, first_name, middle_name, last_name, email, dept_id,
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

                $save_rec = "INSERT INTO tbl_users (username_id, user_password, first_name, middle_name, last_name, tag_to_vote,
                                                           email, dept_id, access_rights, chg_password, added_by, date_added)					 
                             VALUES ('$studentid', OLD_PASSWORD('$user_password'), '$first_name', '$middle_name', '$last_name', 'Y',
                                     '$email', '$dept_id', 'faculty_voter', 'Y', '$user_fname', NOW())";
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
                                    email = '$email', dept_id = '$dept_id',
                                    updated_by = '$user_fname', date_updated = NOW()  $update_pass
                                WHERE rec_id='$rec_id'";
                $result      = mysqli_query($db, $sql_update);


                $sql_cd		    = "SELECT *
                                   FROM tbl_candidates
                                   WHERE student_id = '$old_studentid'";	
                $res_cd         = mysqli_query($db, $sql_cd) or die (mysqli_error($db));
                $row        	= mysqli_fetch_assoc($res_cd);
                $rowcd_cnt      = mysqli_num_rows($res_cd);

                if ($rowcd_cnt > 0) {

                    $sql_update2  = "UPDATE tbl_candidates
                                    SET student_id = '$studentid',
                                        updated_by = '$user_fname', date_updated = NOW()  
                                    WHERE student_id = '$old_studentid'";
                    $result2      = mysqli_query($db, $sql_update2);
                    
                }

                echo "Updated|".$sql_update;
        
            }

            
        } else {
            echo "errorSaving|";
        }

     

    }

	mysqli_close($db); 		
?>