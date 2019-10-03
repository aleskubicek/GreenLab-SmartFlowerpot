<?php
  
   // greenLab 
   // A. Kubiček  |  V. Kaniok  |  M. Bernát
   // php script

   $dbhost = "innodb.endora.cz";
   $dbuser = "";
   $dbpass = "";
   $dbname = "";
   
   $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
      
   $switch = $_GET['switch'];
   $timeFrom = $_GET['timeFrom'];
   $timeTo = $_GET['timeTo'];
   
   $switch = mysqli_real_escape_string($connection, $switch);
   $timeFrom = mysqli_real_escape_string($connection, $timeFrom);
   $timeTo = mysqli_real_escape_string($connection, $timeTo);
   
   $query = mysqli_query($connection,"UPDATE light_fromWeb SET switch='$switch', timeFrom='$timeFrom', timeTo='$timeTo'");
?>