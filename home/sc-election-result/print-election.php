<?php
date_default_timezone_set("Asia/Hong_Kong");
require("../../fpdf184/fpdf.php");
require('../../fpdf184/mc_table.php');
ini_set('display_errors', 1);

include_once('../../connection/mysql_connect.php'); 
// define('DB_SERVER', 'localhost');
// define('DB_USERNAME', 'root');
// define('DB_PASSWORD','');

// define('DB_DATABASE', 'voting');
// $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if (!isset($_SESSION)) { 
  session_start(); 
}

$username_id      = $_SESSION['username_id'];
$access_rights    = $_SESSION['access_rights'];
$fullname         = $_SESSION['fullname'];
$department       = $_SESSION['department'];
$chg_password     = $_SESSION['chg_password'];

$election_id      = $_GET['eid'];
$election_type    = $_GET['etype'];



$sql     = "SELECT a.election_id, a.election_name, b.description, a.date_started, b.election_type,
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




//A4 width : 219mm
//default margin : 10mm each side
//writable horizontal : 219-(10*2)=189mm
//create pdf object
$pdf = new FPDF("P","mm","A4");
$pdf = new PDF_MC_Table('P','mm','A4');
$pdf->AddPage();


$dhvsulogo    = '../../img/dhvsu-logo.png';

$pdf->Image($dhvsulogo,96,10,-550);
$pdf->Ln(17);
$pdf->SetFont("Arial","B",11);
$pdf->Cell(30 ,12,"","",0,"C");
$pdf->Cell(130 ,12,"DON HONORIO VENTURA STATE UNIVERSITY","",0,"C");
$pdf->Cell(30 ,12,"","",0,"C");
$pdf->Ln(5);
$pdf->SetFont("Arial","",11);
$pdf->Cell(30 ,12,"","",0,"C");
$pdf->Cell(130 ,12,"$elec_description","",0,"C");
$pdf->Cell(30 ,12,"","",0,"C");
$pdf->Ln(5);
$pdf->SetFont("Arial","",11);
$pdf->Cell(30 ,12,"","",0,"C");
$pdf->Cell(130 ,12,"$dateOfElection","",0,"C");
$pdf->Cell(30 ,12,"","",0,"C");
$pdf->Ln(14);
$pdf->SetFont("Arial","B",11);
$pdf->Cell(30 ,12,"","",0,"C");
$pdf->Cell(130 ,12,"$canvass_label","",0,"C");
$pdf->Cell(30 ,12,"","",0,"C");
$pdf->Ln(14);
$pdf->SetFont("Arial","B",13);
$pdf->Cell(190 ,7,"Election Winners","",0,"L");
$pdf->Ln(7);
$pdf->SetFont("Arial","B",9);
$pdf->Cell(190 ,7,"$title_total_a: $res_cnt_a","",0,"L");
$pdf->Ln(4);
$pdf->Cell(190 ,7,"$title_total_b: $res_cnt_b","",0,"L");
$pdf->Ln(7);
$pdf->SetFont("Arial","B",8);
$pdf->Cell(20 ,7,"Student ID No.","RLTB",0,"C");
$pdf->Cell(65 ,7,"Name of Candidates","RLTB",0,"C");
$pdf->Cell(75 ,7,"Position","RLTB",0,"C");
$pdf->Cell(30 ,7,"Votes Garnered","RLTB",0,"C");


$sql_canvass      ="SELECT a.student_id, a.first_name, a.middle_name, a.last_name, a.position,c.position_name, a.vote_count 
                    FROM   tbl_candidates a, 
                          (SELECT position, 
                                  Max(vote_count) AS M 
                            FROM   tbl_candidates
                            WHERE  position IN (SELECT DISTINCT( position ) 
                                                FROM tbl_candidates) 
                            GROUP  BY position) b 
                    LEFT JOIN (SELECT rec_id, position_name, position_id FROM tbl_position GROUP BY position_id) c
                    ON c.position_id = b.position
                    WHERE  a.position = b.position  
                    AND a.election_id='$election_id'
                    AND a.vote_count = b.m AND a.vote_count !=0 
                    ORDER BY c.rec_id";
$result_c         = mysqli_query($db,$sql_canvass);

while($row_c = mysqli_fetch_assoc($result_c)) {

    $student_id         = $row_c['student_id'];
    $first_name         = $row_c['first_name'];
    $middle_name        = $row_c['middle_name'];
    $last_name          = $row_c['last_name'];
    $candidate_name     = $last_name.' '.$first_name.', '.$middle_name;
    $position           = $row_c['position'];
    $position_name      = $row_c['position_name'];
    $vote_count         = $row_c['vote_count'];


    $pdf->Ln(7);
    $pdf->SetFont("Arial","",8);
    $pdf->Cell(20 ,7,"$student_id","RLB",0,"C");
    $pdf->Cell(65 ,7,"$candidate_name","RLB",0,"L");
    $pdf->Cell(75 ,7,"$position_name","RLB",0,"CL");
    $pdf->Cell(30 ,7,"$vote_count","RLB",0,"C");

}

$pdf->Ln(15);
$pdf->SetFont("Arial","B",13);
$pdf->Cell(190 ,7,"Election Tally","",0,"L");
$pdf->Ln(7);
$pdf->SetFont("Arial","B",8);
$pdf->Cell(20 ,7,"Student ID No.","RLTB",0,"C");
$pdf->Cell(65 ,7,"Name of Candidates","RLTB",0,"C");
$pdf->Cell(75 ,7,"Position","RLTB",0,"C");
$pdf->Cell(30 ,7,"Votes Garnered","RLTB",0,"C");

$sql    =  "SELECT a.rec_id, a.student_id, a.first_name, a.middle_name, a.last_name,
                   a.position, a.platform, a.election_id, a.dept_id, a.year, b.position_name, a.vote_count
            FROM tbl_candidates a  
            LEFT JOIN (SELECT rec_id, position_name, position_id FROM tbl_position WHERE election_type='$election_type') b
            ON b.position_id = a.position
            WHERE a.election_id='$election_id'
            ORDER BY b.rec_id";
$result = mysqli_query($db, $sql);         

$count = 1;
while($row    = mysqli_fetch_assoc($result)) {

    
    $seq_no               = $count++;
    $rec_id               = $row['rec_id'];
    $student_id_a         = $row['student_id'];
    $first_name           = $row['first_name'];
    $middle_name          = $row['middle_name'];
    $last_name            = $row['last_name'];
    $position             = $row['position'];
    $platform             = $row['platform'];
    $election_id          = $row['election_id'];
    $dept_id              = $row['dept_id'];
    $year                 = $row['year'];
    $post_name_a          = $row['position_name'];
    $vote_count_a         = $row['vote_count'] ?? '';
    $candidate_name_a     = $last_name.', '.$first_name.'. '.$middle_name;


    $sql1           = "SELECT * FROM tbl_users
                        WHERE active = 'Y' and access_rights = 'std_voter'";
    $result1        = mysqli_query($db, $sql1);           
    $total_voter    = mysqli_num_rows($result1);

    $vote_perc      = number_format(($vote_count_a / $total_voter) * 100,2) ?? '';


    
    $pdf->Ln(7);
    $pdf->SetFont("Arial","",8);
    $pdf->Cell(20 ,7,"$student_id_a","RLB",0,"C");
    $pdf->Cell(65 ,7,"$candidate_name_a","RLB",0,"L");
    $pdf->Cell(75 ,7,"$post_name_a","RLB",0,"CL");
    $pdf->Cell(30 ,7,"$vote_count_a","RLB",0,"C");


}


$timestamp     = date("m/d/Y g:i a");
$pdf->Ln(10);
$pdf->SetFont("Arial","",5);
$pdf->SetTextColor(109,109,109);
$pdf->Cell(190 ,4,"Date Printed: $timestamp","",0,"R");

$filename = $election_id . ".pdf";

$pdf->Output($filename,"I");
?>