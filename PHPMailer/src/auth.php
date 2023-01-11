<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


$phpmailer = new PHPMailer();
$phpmailer->isSMTP();
//$phpmailer->Host = 'smtp-mail.outlook.com';
// $phpmailer->Host = 'smtp.office365.com';
// $phpmailer->SMTPAuth = true;
// $phpmailer->Port = 587;
// $phpmailer->Username = 'dhvsu_voting_system@outlook.com';
// $phpmailer->Password = 'dhvsuvotingsystem123';
$phpmailer->Host = 'mail.dhvsu-e-voting.online';
$phpmailer->SMTPAuth = true;
$phpmailer->Port = 587;
$phpmailer->Username = 'dhvsu_voting_system@dhvsu-e-voting.online';
$phpmailer->Password = 'CoPYJdPiy~Js';

?>