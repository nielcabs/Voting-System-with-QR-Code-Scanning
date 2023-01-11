<?php
   session_start();
   if(session_destroy()) {
	   session_destroy();
       $_SESSION['username_id']='';
      header("Location: ../");
	  
   }
?>