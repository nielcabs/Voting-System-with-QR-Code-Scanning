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
        $dept_id                = mysqli_real_escape_string($db,$_POST['dept_id']);
        $department             = mysqli_real_escape_string($db,$_POST['department']);
        $action                 = mysqli_real_escape_string($db,$_POST['action']);

        if($rec_id == '' && $action =='Add'){
           
            //Check User if already exist	
            $sql_chk		= "SELECT *
                               FROM tbl_department
                               WHERE dept_id ='$dept_id'";	
            $res_chk        = mysqli_query($db, $sql_chk) or die (mysqli_error($db));
            $row        	= mysqli_fetch_assoc($res_chk);
            $row_cnt        = mysqli_num_rows($res_chk);	
            $dptid            = $row['dept_id'] ?? null;

            if ($row_cnt > 0) {
                echo "exist|".$dptid;    
            } else {   

                $save_rec = "INSERT INTO tbl_department (dept_id, department)					 
                             VALUES ('$dept_id', '$department')";
                $result     = mysqli_query($db, $save_rec);
    
                echo "Saved|";
        
            }

        } else if ($action =="Update" && $rec_id !='') {

            //Check User if already exist	
            $sql_chk		= "SELECT *
                               FROM tbl_department
                               WHERE rec_id != '$rec_id' AND dept_id ='$dept_id'";	
            $res_chk        = mysqli_query($db, $sql_chk) or die (mysqli_error($db));
            $row        	= mysqli_fetch_assoc($res_chk);
            $row_cnt        = mysqli_num_rows($res_chk);	
            $dptid            = $row['dept_id'] ?? null;
 
            if ($row_cnt > 0) {
                echo "exist|".$dptid;  
            } else {  


                $sql_update  = "UPDATE tbl_department
                                SET dept_id = '$dept_id', department = '$department'
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