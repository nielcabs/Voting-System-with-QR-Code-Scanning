<?php
  
   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD','');

   define('DB_DATABASE', 'dhvsuevo_voting');
   $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
   
   mysqli_set_charset($db,"utf8");
   
   $myWebTitles = 'E-Voting System';
?>


