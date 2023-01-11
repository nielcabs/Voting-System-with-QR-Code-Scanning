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
        $party_name             = mysqli_real_escape_string($db,$_POST['party_name']);
        $election_type          = mysqli_real_escape_string($db,$_POST['election_type']);
        $department             = mysqli_real_escape_string($db,$_POST['department']);
        $action                 = mysqli_real_escape_string($db,$_POST['action']);
        $electionID             = mysqli_real_escape_string($db,$_POST['election_id']);

        if($rec_id == '' && $action =='Add'){
           
    
            $save_rec = "INSERT INTO tbl_party (party_name, election_type, dept_id, election_id, election_status)					 
                            VALUES ('$party_name', '$election_type', '$department', '$electionID', 'N')";
            $result     = mysqli_query($db, $save_rec);

            echo "Saved|";
        
       

        } else if ($action =="Update" && $rec_id !='') {

       

            $sql_update  = "UPDATE tbl_party
                            SET party_name = '$party_name', dept_id = '$department', election_type = '$election_type', election_id = '$electionID'
                            WHERE rec_id='$rec_id'";
            $result      = mysqli_query($db, $sql_update);

            echo "Updated|";
        
         

            
        } else {
            echo "errorSaving|";
        }

     

    }

	mysqli_close($db); 		
?>