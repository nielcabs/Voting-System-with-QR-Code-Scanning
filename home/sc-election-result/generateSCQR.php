<?php
    if (!isset($_SESSION)) { 
        session_start(); 
    } 
    
    $url                = "../../";
    include_once($url.'connection/mysql_connect.php');

    $election_id    = $_POST['election_id'];

  echo  $sql     = "SELECT a.election_id, a.election_name, b.description, a.date_started, b.election_type,
                    a.department
                FROM tbl_election a
                LEFT JOIN tbl_election_type b
                ON b.election_type = a.election_name 
                WHERE a.election_id = '$election_id'";
    $result  = mysqli_query($db, $sql);
    $row     = mysqli_fetch_assoc($result);

    $election_id1         = $row['election_id'];
    $election_name        = $row['election_name'];
    $elec_description     = $row['description'];
    $date_started         = $row['date_started'];
    $election_type        = $row['election_type'];
    $dept_id              = $row['department'];
    $election_type1       = strtoupper($election_type);
    $dateOfElection       = strtoupper(date('F d, Y',strtotime($date_started)));


    if($election_name =='LDSC') {

  

        $sql     = "SELECT dept_id, department
                    FROM tbl_department
                    WHERE dept_id='$dept_id'";
        $result  = mysqli_query($db, $sql);
        $row     = mysqli_fetch_assoc($result);
      
        $depart_name          = $row['department'];
      
        $elec_description     = $dateOfElection.' '.strtoupper($depart_name).' STUDENT COUNCIL ELECTIONS';
        $canvass_label        = strtoupper($dept_id)." CANVASS REPORT";
      
        $title_total_a          = "Total Number of Registered Voters for ".strtoupper($dept_id);
        $title_total_b          = "Total Number of Voters that Actually Voted for ".strtoupper($dept_id);
      
        $sql    = "SELECT * FROM tbl_users
                   WHERE active = 'Y' AND dept_id='$dept_id'";
        $result = mysqli_query($db, $sql);           
        $res_cnt_a = mysqli_num_rows($result);
      
      
        $sql1    = "SELECT * 
                    FROM tbl_voter_status a
                    LEFT JOIN tbl_election b
                    ON a.election_id = b.election_id
                    WHERE a.election_id = '$election_id' AND b.department='$dept_id'";
        $result1 = mysqli_query($db, $sql1);           
        $res_cnt_b = mysqli_num_rows($result1);
      
    } else if ($election_name =='USC'){
      
        $elec_description     = $dateOfElection.' '.strtoupper($elec_description).' ELECTIONS';
        $canvass_label        = strtoupper($election_type1)." CANVASS REPORT";
      
        $title_total_a          = "Total Number of Registered Voters";
        $title_total_b          = "Total Number of Voters that Actually Voted";
      
        $sql    = "SELECT * FROM tbl_users
                   WHERE active = 'Y' AND access_rights IN ('std_voter')";
        $result = mysqli_query($db, $sql);           
        $res_cnt_a = mysqli_num_rows($result);
      
         $sql1    = "SELECT * 
                    FROM tbl_voter_status a
                    LEFT JOIN tbl_election b
                    ON a.election_id = b.election_id
                    WHERE a.election_id = '$election_id'";
        $result1 = mysqli_query($db, $sql1);           
        $res_cnt_b = mysqli_num_rows($result1);
    }


    $doc_type = 'CS';
    include('../../QRCodeFiles/vote-result-qrcode.php');

   // echo "Printed Vote Result";
  


?>