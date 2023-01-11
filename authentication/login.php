<?php

    $url='../';
    include($url.'connection/mysql_connect.php');
 
    //session_start();
    
    $uname         = mysqli_real_escape_string($db,$_POST['username']);
    $code          = mysqli_real_escape_string($db,$_POST['code']);
   


    $sql        = "SELECT * 
                   FROM tbl_users 
                   WHERE username_id = '$uname' 
                   AND code = '$code'";
    $result     = mysqli_query($db,$sql);
    $row        = mysqli_fetch_assoc($result);

    $access_rights      = $row['access_rights'] ?? '';
    $username_id        = $row['username_id'] ?? '';
    $first_name         = $row['first_name'] ?? '';
    $middle_name        = $row['middle_name'] ?? '';
    $last_name          = $row['last_name'] ?? '';
    $mname_sub          = substr($middle_name,0,1);
    $fullname           = $first_name.' '.$mname_sub.'. '.$last_name;
    //$fullname           = $first_name.' '.$middle_name.' '.$last_name;
    $department         = $row['dept_id'] ?? '';
    $year_lvl           = $row['year'] ?? '';  
    $dept_id            = $row['dept_id'] ?? ''; 
    $email              = $row['email'] ?? '';  
    $chg_password       = $row['chg_password'] ?? '';     
    $active             = $row['active'] ?? '';          
    $auth_login         = $row['auth_login'] ?? ''; 
    //Check Election USC
    $sql_usc      = "SELECT election_id, election_name, status, department
                     FROM tbl_election
                     WHERE election_name='USC' AND status = 'In-Progress'";
    $result_usc   = mysqli_query($db,$sql_usc); 
    $row_usc      = mysqli_fetch_assoc($result_usc);

    $election_id_usc      = $row_usc['election_id'] ?? '';
    $status_elec_usc      = $row_usc['status'] ?? '';


    //Check Election SC
    $sql_dept      = "SELECT election_id, election_name, status, department
                      FROM tbl_election
                      WHERE election_name='LDSC' AND department='$dept_id' AND status = 'In-Progress'";
    $result_dept   = mysqli_query($db,$sql_dept); 
    $row_dept      = mysqli_fetch_assoc($result_dept);

    $election_id_dept      = $row_dept['election_id'] ?? '';
    $status_elec_dept      = $row_dept['status'] ?? '';


     //Check Election Faculty
    $sql_fce      = "SELECT election_id, election_name, status, department
                      FROM tbl_election
                      WHERE election_name='FCE' AND status = 'In-Progress'";
    $result_fce   = mysqli_query($db,$sql_fce); 
    $row_fce      = mysqli_fetch_assoc($result_fce);

    $election_id_fce        = $row_fce['election_id'] ?? '';
    $status_elec_fce        = $row_fce['status'] ?? '';

	  
    // If result matched username and password, table row must be 1 row
	$count      = mysqli_num_rows($result);	
    if ($count == 1) {

        if($active =="Y"){
            session_start();
            $_SESSION['E_Voting_System']        = $username_id;
            $_SESSION['username_id']            = $username_id;
            $_SESSION['access_rights']          = $access_rights;
            $_SESSION['fullname']               = $fullname;
            $_SESSION['department']             = $dept_id;
            $_SESSION['year_lvl']               = $year_lvl;
            $_SESSION['logged_system']          = "EVS";
            $_SESSION['chg_password']           = $chg_password;

            $_SESSION['first_name']             = $first_name;
            $_SESSION['middle_name']            = $middle_name;
            $_SESSION['last_name']              = $last_name;
            $_SESSION['dept_id']                = $dept_id;
            $_SESSION['email']                  = $email;

            //Session Election
            $_SESSION['election_id_usc']        = $election_id_usc;
            $_SESSION['status_elec_usc']        = $status_elec_usc;

            $_SESSION['election_id_dept']       = $election_id_dept;
            $_SESSION['status_elec_dept']       = $status_elec_dept;

            $_SESSION['election_id_fce']        = $election_id_fce;
            $_SESSION['status_elec_fce']        = $status_elec_fce;
        }
        
        
        if ($chg_password == 'Y'  && $active =='Y')  {
            echo "ch_pass|".$active;
        } else {  
            if ($access_rights == 'SUPERADMIN' && $active =='Y') {
                echo "super_admin|".$active;
            } else if ($access_rights == 'faculty_admin' && $active =='Y')  {
                echo "faculty_admin|".$active;
            } else if ($access_rights == 'std_admin'  && $active =='Y')  {
                echo "std_admin|".$active;
            } else if ($access_rights == 'std_voter'  && $active =='Y')  {
                echo "std_voter|".$active;
            } else if ($access_rights == 'faculty_voter'  && $active =='Y')  {
                echo "faculty_voter|".$active;
            } else if ($active =="N")  {
                echo "inactive|".$active;
            }  else {
                echo "error|";
            }
        }

    } else {
        echo  "Invalid Verification Code!";
    }
   
    mysqli_close($db);
?>