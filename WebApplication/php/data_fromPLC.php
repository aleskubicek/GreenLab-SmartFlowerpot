<?php

   // greenLab 
   // A. Kubiček  |  V. Kaniok  |  M. Bernát
   // php script
  
   $dbhost = "innodb.endora.cz";
   $dbuser = "";
   $dbpass = "";
   $dbname = "";
   
   $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
      
   $temp = $_GET['temp'];
   $hum_out = $_GET['hum_in'];
   $hum_in = $_GET['hum_out'];
   $lux = $_GET['lux'];
   
   $temp = mysqli_real_escape_string($connection, $temp);
   $hum_out = mysqli_real_escape_string($connection, $hum_out);
   $hum_in = mysqli_real_escape_string($connection, $hum_in);
   $lux = mysqli_real_escape_string($connection, $lux);
   
   $query = mysqli_query($connection,"UPDATE realTime_fromPLC SET temp='$temp', hum_out='$hum_out', hum_in='$hum_in', lux='$lux'");
?>