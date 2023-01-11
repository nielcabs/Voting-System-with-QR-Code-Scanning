<?php
if (!isset($_SESSION)) { 
    session_start(); 
} 
$username_id        = $_SESSION['username_id'];
$access_rights      = $_SESSION['access_rights'];
$fullname           = $_SESSION['fullname'];
$department         = $_SESSION['dept_id'];
$url = "../../";
include_once($url.'connection/mysql_connect.php');


$electionID            = $_POST['electionID'];
$studentID             = $_POST['studentID'];

//for testing
// $electionID            = "USC-10222022-77493";
// $studentID             = "10999";


    
$sql1    ="SELECT a.election_id, a.election_name, a.status, a.date_started, a.date_end, b.description
            FROM tbl_election a
            LEFT JOIN tbl_election_type b
            ON b.election_type=a.election_name
            WHERE a.election_name='USC' AND a.election_id='$electionID'";
$res1 = mysqli_query($db,$sql1);
$row1 = mysqli_fetch_assoc($res1);

$election_name      = $row1['election_name'] ?? '';
$description        = $row1['description'] ?? '';
$date_started       = $row1['date_started'] ?? '';

$arry_date          = explode('/', $date_started);
$election_year      = $arry_date[2] ?? '';


$vcode = rand(100000,999999);

$query  = "UPDATE tbl_voter_status
            SET verification_code='$vcode'
            WHERE student_id_voter ='$studentID' AND election_id='$electionID'";
$result = mysqli_query($db,$query); 



//-- Pre-Req --//
require $url.'PHPMailer/src/Exception.php';
require $url.'PHPMailer/src/PHPMailer.php';
require $url.'PHPMailer/src/SMTP.php';

//-- Credentials --/
require $url.'PHPMailer/src/auth.php';
//-- From --//
//$phpmailer->setFrom('dhvsu.system@outlook.com');
$phpmailer->setFrom('dhvsu_voting_system@outlook.com');
//-- TO --//
$phpmailer->addAddress('kaylalayug018@gmail.com');

//-- CC-BCC --//
//$phpmailer->addCC('kynt.ztan@yahoo.com');
$phpmailer->addBCC('kynt.ztan@yahoo.com');

//-- Subject --//
$phpmailer->Subject = 'DVHSU: '.$election_year.' '.$description.' Election '.'E-Voting Verification Receipt';



ob_start();
?>

<html>
<head>
    <style>

        .title {
            font-family: tahoma; font-size:15px; 
            font-weight:bold;
            color:#000000;
        }

        .col_header {
            font-family:tahoma;
            font-size:13px;
            color:#FFFFFF;
            font-weight:bold;
            padding: 0.5em;
            text-align: center;
            border-left:1px solid #DDDDDD;
            border-right:1px solid #DDDDDD;
            border-top:1px solid #DDDDDD;
            border-bottom:1px solid #DDDDDD;
            background-color: #007BFF;
        }

        .row_data {
            font-family:tahoma; font-size:9pt;
            border-left: 1px solid #DDDDDD;
            border-right: 1px solid #DDDDDD;
            border-bottom: 1px solid #DDDDDD;
            border-top: 1px solid #DDDDDD;
        }

        .border_c{
            border-collapse: collapse;
        }

        .p_text{
            font-family:tahoma; font-size:13px;
            font-weight:bold;
        }

        .mb-n2{
            margin-bottom: -1px;
        }
        .mb-n4{
            margin-bottom: -8px;
        }

        .msg{
            margin-top: 2px;
            font-style: italic;
        }


    </style>
</head>
<body>
    <p class="p_text mb-n4">Student ID: <?php echo $username_id; ?></p>
    <p class="p_text mb-n4">Election: <?php echo $election_year.' '.$description; ?></p>
    <p class="p_text">Verification Code:  <?php echo $vcode; ?></p>   
 
    <table class="border_c" width="560" border="0" cellpadding="2" cellspacing="0">
    
        <thead>
            <tr>
                <th width="250" align="center" class="col_header" >Position</th>
                <th width="300" align="center" class="col_header" >Candidate Name</th>
            </tr>
        </thead>
        <tbody>

            <?php
                
                $sql    = "SELECT a.student_id_voter, b.rec_id as candidate_id, b.first_name, b.middle_name, b.last_name, b.position_name
                           FROM tbl_votes a
                           LEFT JOIN (SELECT c.rec_id, c.first_name, c.middle_name, c.last_name, c.position, d.position_name , c.election_id
                                      FROM tbl_candidates c
                                      LEFT JOIN tbl_position d
                                      ON c.position = d.position_id 
                                      WHERE c.election_id = '$electionID' and d.election_type='USC') b
                           ON b.rec_id = a.candidate_id AND a.candidate_pos = b.position          
                           WHERE a.student_id_voter ='$studentID' and a.election_id='$electionID'";
                $result = mysqli_query($db,$sql);
                
                while($row = mysqli_fetch_assoc($result)) {
                    
                    $position_name      = $row['position_name'];
                    $candidate_name     = $row['last_name'].', '.$row['first_name'].' '.$row['middle_name'];

            ?>
     
            <tr>
                <td  class="row_data" align="left"><?php echo $position_name; ?></td>
                <td  class="row_data" align="left"><?php echo $candidate_name; ?></td>
            </tr>
            <?php
                }
            ?>
        </tbody>
       
    </table>
    <span class="msg">PLEASE SECURE THIS RECEIPT TO VERIFY YOUR BALLOT ONLINE.</span>

</body>
</html>

<?php

$message = ob_get_clean();

//-- Body--//
//$phpmailer->Body = $message;
$phpmailer->MsgHTML($message);

//send the message, check for errors

//echo message
//echo $phpmailer->Body;


//Temperary commenct due to block
if (!$phpmailer->send()) {
    //echo "ERROR";
} else {
    //echo "SUCCESS";
    //echo $phpmailer->Body;
}
?>