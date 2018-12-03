<?php
   $dbhost = 'localhost';
   $dbuser = 'root';
   $dbpass = '';
   $dbname = 'tictactoe';

   $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

   if(! $conn ){
      die('Could not connect: ' . mysqli_error());
   }
   //echo 'Connected successfully';
   //mysqli_close($conn);
