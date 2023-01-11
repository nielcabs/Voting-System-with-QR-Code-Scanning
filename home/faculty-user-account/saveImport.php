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

        $pushToPost     = $_POST['pushToPost'];
        $count          = $_POST['count'];

        $student_data   = explode('~', $pushToPost);

        for($i=1; $i <= $count; $i++){

            $arr_data = explode('|', $student_data[$i]);

            $student_id         = $arr_data[0];
            $first_name         = $arr_data[1];
            $middle_name        = $arr_data[2];
            $last_name          = $arr_data[3];
            $email              = $arr_data[4];
            $dept_id            = $arr_data[5];

             //Check User if already exist	
            $sql_chk		= "SELECT rec_id, username_id, first_name, middle_name, last_name, email, dept_id, year,
                                          access_rights, vote_status, active, chg_password, date_added, date_updated,
                                          last_login
                               FROM tbl_users
                               WHERE username_id ='$student_id'";	
            $res_chk        = mysqli_query($db, $sql_chk) or die (mysqli_error($db));
            $row        	= mysqli_fetch_assoc($res_chk);
            $row_cnt        = mysqli_num_rows($res_chk);	
            $user_id        = $row['username_id'] ?? '';

            //Check User dept if exist	
            $sql_chk1		    = "SELECT rec_id, dept_id, department
                                   FROM tbl_department
                                   WHERE dept_id ='$dept_id'";	
            $res_chk1           = mysqli_query($db, $sql_chk1) or die (mysqli_error($db));
            $row1       	    = mysqli_fetch_assoc($res_chk1);	
            $row_cnt1        = mysqli_num_rows($res_chk1);
            $dept_id_chk        = $row1['dept_id'] ?? '';

            if ($row_cnt > 0) {
                echo "already exist.|".$user_id;    
            } else if ($row_cnt1 == 0) {
                echo "deptidnotfoundindatabase|".$dept_id;    
            } else {   

                $save_rec = "INSERT INTO tbl_users (username_id, user_password, first_name, middle_name, last_name, tag_to_vote,
                                                           email, dept_id, access_rights, chg_password, added_by, date_added)					 
                             VALUES ('$student_id', OLD_PASSWORD('$student_id'), '$first_name', '$middle_name', '$last_name', 'Y',
                                     '$email', '$dept_id', 'faculty_voter', 'Y', '$user_fname', NOW())";
                $result     = mysqli_query($db, $save_rec);

        
            }

        }

        if ($result) {
            echo "Imported Successfully!|";
        } else {
            echo "Error importing data.|";
        }

    }

	mysqli_close($db); 		
?>