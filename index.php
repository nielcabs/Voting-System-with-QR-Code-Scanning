<?php
//include_once('mysql_connect.php');

if (!isset($_SESSION)) { 
	session_start(); 
} 

   if(!isset($_SESSION['E_Voting_System'])){
   		//header("location:signin/");;
		echo "<script type='text/javascript'>window.location = 'signin/';</script>";
		//echo 'signin';
   }else{
   		//header("location:home/");
		echo "<script type='text/javascript'>window.location = 'home/';</script>";
	//	echo 'home';
   }
?>
