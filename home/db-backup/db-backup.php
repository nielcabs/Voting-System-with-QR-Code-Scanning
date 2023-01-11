<?php
    if (!isset($_SESSION)) { 
        session_start(); 
    } 
    error_reporting(0);

	include_once 'backup_function.php';

		
    $server         = $_POST['server'];
    $username       = $_POST['username'];
    $password       = $_POST['password'];
    $dbname         = $_POST['dbname'];

    // $server         = "localhost";
    // $username       = "root";;
    // $password       = "";
    // $dbname         = "voting";

    
    backDb($server, $username, $password, $dbname);

    exit();
    
	

?>









