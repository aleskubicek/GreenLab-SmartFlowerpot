<?php

	// greenLab 
   // A. Kubiček  |  V. Kaniok  |  M. Bernát
   // php script
  
   $dbhost = "innodb.endora.cz";
   $dbuser = "";
   $dbpass = "";
   $dbname = "";
   
   $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
      
   $lux = $_GET['lux'];
   
   $lux = mysqli_real_escape_string($connection, $lux);
   
   $query = mysqli_query($connection,"UPDATE lux_fromWeb SET lux='$lux'");
?>