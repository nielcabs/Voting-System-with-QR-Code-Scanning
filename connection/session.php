<?php
   if (!isset($_SESSION)) { 
      session_start(); 
   } 

    if (!isset($_SESSION['E_Voting_System'])){
            header("Location:$url");
   } 



?>


