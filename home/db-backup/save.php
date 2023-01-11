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
        echo "Relogin|";
    } else {

        $rec_id                 = mysqli_real_escape_string($db,$_POST['rec_id']);
        $election_name          = mysqli_real_escape_string($db,$_POST['election_name']);
        $election_id            = mysqli_real_escape_string($db,$_POST['election_id']);
        $department             = mysqli_real_escape_string($db,$_POST['department']);
        $date_started           = mysqli_real_escape_string($db,$_POST['date_started']);
        $action                 = mysqli_real_escape_string($db,$_POST['action']);

        if($rec_id == '' && $action =='Add'){
           
            //Check User if already exist	
            $sql_chk		= "SELECT *
                               FROM tbl_election
                               WHERE election_id ='$election_id'";	
            $res_chk        = mysqli_query($db, $sql_chk) or die (mysqli_error($db));
            $row        	= mysqli_fetch_assoc($res_chk);
            $row_cnt        = mysqli_num_rows($res_chk);	
            $eid            = $row['election_id'] ?? null;

            if ($row_cnt > 0) {
                echo "exist|".$eid;    
            } else {   

                $save_rec = "INSERT INTO tbl_election (election_id, election_name, department, status, date_started, date_created, added_by)					 
                             VALUES ('$election_id', '$election_name', '$department', 'N', '$date_started', NOW(), '$user_fname')";
                $result     = mysqli_query($db, $save_rec);
    
                echo "Saved|";
        
            }

        } else if ($action =="Update" && $rec_id !='') {

            //Check User if already exist	
            $sql_chk		= "SELECT *
                               FROM tbl_election
                               WHERE rec_id != '$rec_id' AND election_id ='$election_id'";	
            $res_chk        = mysqli_query($db, $sql_chk) or die (mysqli_error($db));
            $row        	= mysqli_fetch_assoc($res_chk);
            $row_cnt        = mysqli_num_rows($res_chk);	
            $eid            = $row['election_id'] ?? null;
 
            if ($row_cnt > 0) {
                echo "exist|".$eid;  
            } else {  


                $sql_update  = "UPDATE tbl_election
                                SET election_name = '$election_name', department = '$department', date_started = '$date_started',
                                    updated_by = '$user_fname', date_updated = NOW()
                                WHERE rec_id='$rec_id'";
                $result      = mysqli_query($db, $sql_update);

                echo "Updated|";
        
            }

            
        } else {
            echo "errorSaving|";
        }

     

    }

	mysqli_close($db); 		
?>