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
        $position_id            = mysqli_real_escape_string($db,$_POST['position_id']);
        $position_name          = mysqli_real_escape_string($db,$_POST['position_name']);
        $action                 = mysqli_real_escape_string($db,$_POST['action']);
        $election_type          = mysqli_real_escape_string($db,$_POST['election_type']);
        
        if($rec_id == '' && $action =='Add'){
           
            //Check User if already exist	
            $sql_chk		= "SELECT *
                               FROM tbl_position
                               WHERE position_id ='$position_id' AND election_type='$election_type'";	
            $res_chk        = mysqli_query($db, $sql_chk) or die (mysqli_error($db));
            $row        	= mysqli_fetch_assoc($res_chk);
            $row_cnt        = mysqli_num_rows($res_chk);	
            $pid            = $row['position_id'] ?? null;

            if ($row_cnt > 0) {
                echo "exist|".$pid;    
            } else {   

                $save_rec = "INSERT INTO tbl_position (position_id, position_name, election_type, added_by, date_added)					 
                             VALUES ('$position_id', '$position_name', '$election_type', '$user_fname', NOW())";
                $result     = mysqli_query($db, $save_rec);
    
                echo "Saved|";
        
            }

        } else if ($action =="Update" && $rec_id !='') {

            //Check User if already exist	
            $sql_chk		= "SELECT *
                               FROM tbl_position
                               WHERE rec_id != '$rec_id' AND position_id ='$position_id' AND election_type='$election_type'";	
            $res_chk        = mysqli_query($db, $sql_chk) or die (mysqli_error($db));
            $row        	= mysqli_fetch_assoc($res_chk);
            $row_cnt        = mysqli_num_rows($res_chk);	
            $pid            = $row['position_id'] ?? null;
 
            if ($row_cnt > 0) {
                echo "exist|".$pid;  
            } else {  


                $sql_update  = "UPDATE tbl_position
                                SET position_id = '$position_id', position_name = '$position_name', election_type = '$election_type',
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