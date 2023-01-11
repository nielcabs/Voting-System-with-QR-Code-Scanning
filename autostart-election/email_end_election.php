<?php

$url = "../";

include_once($url.'connection/mysql_connect.php');



//for testing
// $username          = '161616';
// $email_add         = 'kaylalayug018@gmail.com';
// $newpass           = '123456';

//-- Pre-Req --//
require $url.'PHPMailer/src/Exception.php';
require $url.'PHPMailer/src/PHPMailer.php';
require $url.'PHPMailer/src/SMTP.php';

//-- Credentials --/
require $url.'PHPMailer/src/auth.php';

if($election_name =="USC") {
    $query = "WHERE access_rights ='std_voter'";
} else if ($election_name =="FCE") {
    $query = "WHERE access_rights ='faculty_voter'";
} else if ($election_name =="LDSC") {
    $query = "WHERE access_rights ='std_voter' AND dept_id = '$dept_id'";
}

$sql_em         = "SELECT email 
                   FROM tbl_users
                   $query";
$res_em         = mysqli_query($db, $sql_em);

while ($row_em = mysqli_fetch_assoc($res_em)) {

    $to_email  = $row_em['email'] ?? '';




//-- From --//
//$phpmailer->setFrom('dhvsu.system@outlook.com');
$phpmailer->setFrom('dhvsu_voting_system@dhvsu-e-voting.online');
//-- TO --//
$phpmailer->addAddress($to_email);

//-- CC-BCC --//
$phpmailer->addCC('kaylalayug018@gmail.com');
$phpmailer->addBCC('jonathanluis.jlcb@gmail.com');

//-- Subject --//
$phpmailer->Subject = 'DVHSU E-Voting System Notification: '. $subject;



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
    <br>
    <p class="p_text mb-n4">This is to notify you that election for <?php echo $subject; ?> upon receiving this email.</p>
    <br>
    
    <p class="p_text">Kind Regards, </p>  
    <p class="p_text">Don Honorio Ventura State University,</p> 
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

}//end email loop
mysqli_close($db); 		
?>
