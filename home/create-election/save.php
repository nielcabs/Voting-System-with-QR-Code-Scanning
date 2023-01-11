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
        $date_end               = mysqli_real_escape_string($db,$_POST['date_end']);
        $action                 = mysqli_real_escape_string($db,$_POST['action']);
        $date_start_time        = mysqli_real_escape_string($db,$_POST['date_start_time']);
        $date_end_time          = mysqli_real_escape_string($db,$_POST['date_end_time']);

      

        if($rec_id == '' && $action =='Add'){
           
            //Check User if already exist	
            $sql_chk		= "SELECT *
                               FROM tbl_election
                               WHERE election_id ='$election_id'";	
            $res_chk        = mysqli_query($db, $sql_chk) or die (mysqli_error($db));
            $row        	= mysqli_fetch_assoc($res_chk);
            $row_cnt        = mysqli_num_rows($res_chk);	

            //Check  if USC/FCE election is already active	
            $elec_id_ex     = explode("-","$election_id");
            
            $sql_usc		= "SELECT *
                               FROM tbl_election
                               WHERE election_name ='$elec_id_ex[0]' AND (status='In-Progress' OR status='N')";	
            $res_usc        = mysqli_query($db, $sql_usc) or die (mysqli_error($db));
            $check_usc      = mysqli_num_rows($res_usc);	

            //Check if Local Dept election is already active	
            $sql_dept		= "SELECT *
                               FROM tbl_election
                               WHERE election_name ='$elec_id_ex[0]'
                               AND department ='$elec_id_ex[1]' AND (status='In-Progress' OR status='N')";	
            $res_dept        = mysqli_query($db, $sql_dept) or die (mysqli_error($db));
            $check_dept      = mysqli_num_rows($res_dept);	

 
            //Restrict the election (once a year) USC/FCE
            $current_year       = date('Y');
            $sql1		        = "SELECT *
                                   FROM tbl_election
                                   WHERE election_name ='$elec_id_ex[0]' AND dyear='$current_year'";	
            $res1               = mysqli_query($db, $sql1) or die (mysqli_error($db));
            $check_elec_year_1    = mysqli_num_rows($res1);

            //Restrict the election (once a year) by Dept
            $current_year       = date('Y');
            $sql2		        = "SELECT *
                                   FROM tbl_election
                                   WHERE election_name ='$elec_id_ex[0]' AND dyear='$current_year' AND department ='$elec_id_ex[1]'";	
            $res2               = mysqli_query($db, $sql2) or die (mysqli_error($db));
            $check_elec_year_2  = mysqli_num_rows($res2);

       
            if ($row_cnt > 0) {
                echo "exist|";    
            } else if ($check_elec_year_1 > 0 && $elec_id_ex[0] =='USC') {
                echo "exist_usc_election_for_the_year|$current_year";    
            } else if ($check_elec_year_1 > 0 && $elec_id_ex[0] =='FCE') {
                echo "exist_fce_election_for_the_year|$current_year";    
            } else if ($check_elec_year_2 > 0 && $elec_id_ex[0] =='LDSC') {
                echo "exist_ldsc_election_for_the_year|".$elec_id_ex[1]."|".$current_year;    
            }  else if ($check_usc > 0 && $elec_id_ex[0] =='USC') {
                echo "exist_usc|";    
            } else if ($check_usc > 0 && $elec_id_ex[0] =='FCE') {
                echo "exist_fce|";    
            } else if ($check_dept > 0 && $elec_id_ex[0] =='LDSC') {
                echo "exist_elec_dept|".$sql_dept;    
            } else {   

               
                $date_started_arr     = explode("/","$date_started");
                $dmo                  = $date_started_arr[0];
                $dyear                = $date_started_arr[2];

                $save_rec = "INSERT INTO tbl_election (election_id, election_name, department, status, date_started, date_end, date_created, added_by, date_start_time, date_end_time, dmo, dyear)					 
                             VALUES ('$election_id', '$election_name', '$department', 'N', '$date_started', '$date_end', NOW(), '$user_fname', '$date_start_time', '$date_end_time', '$dmo', '$dyear')";
                $result     = mysqli_query($db, $save_rec);
    
                echo "Saved|";
        
            }

        } else if ($action =="Update" && $rec_id !='') {

            //Check User if already exist	
            $sql_chk		= "SELECT *
                               FROM tbl_election
                               WHERE rec_id != '$rec_id' AND election_id ='$election_id'";	
            $res_chk        = mysqli_query($db, $sql_chk) or die (mysqli_error($db));
            $row_cnt        = mysqli_num_rows($res_chk);	

            //Check  if USC/FCE election is already active	
            $elec_id_ex     = explode("-","$election_id");
            $sql_usc		= "SELECT *
                            FROM tbl_election
                            WHERE election_name ='$elec_id_ex[0]' AND (status='In-Progress' OR status='N') AND rec_id != '$rec_id'";	
            $res_usc        = mysqli_query($db, $sql_usc) or die (mysqli_error($db));
            $check_usc      = mysqli_num_rows($res_usc);	

            //Check if Local Dept election is already active	
            $sql_dept		= "SELECT *
                            FROM tbl_election
                            WHERE election_name ='$elec_id_ex[0]'
                            AND department ='$elec_id_ex[1]' AND (status='In-Progress' OR status='N') AND rec_id != '$rec_id'";	
            $res_dept        = mysqli_query($db, $sql_dept) or die (mysqli_error($db));
            $check_dept      = mysqli_num_rows($res_dept);
 
            if ($row_cnt > 0) {
                echo "exist|";  
            } else if ($check_usc > 0 && $elec_id_ex[0] =='USC') {
                echo "exist_usc|";    
            } else if ($check_usc > 0 && $elec_id_ex[0] =='FCE') {
                echo "exist_fce|";    
            } else if ($check_dept > 0 && $elec_id_ex[0] =='LDSC') {
                echo "exist_elec_dept|".$sql_dept;    
            } else {  


                $sql_update  = "UPDATE tbl_election
                                SET election_id = '$election_id', election_name = '$election_name', department = '$department', date_started = '$date_started',
                                    updated_by = '$user_fname', date_updated = NOW(), date_end = '$date_end', date_start_time = '$date_start_time', date_end_time = '$date_end_time'
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