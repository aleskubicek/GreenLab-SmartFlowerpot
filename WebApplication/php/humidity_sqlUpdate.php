<?php

	// greenLab 
   // A. Kubiček  |  V. Kaniok  |  M. Bernát
   // php script
  
   $dbhost = "innodb.endora.cz";
   $dbuser = "";
   $dbpass = "";
   $dbname = "";
   
   $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
      
   $humidity = $_GET['humidity'];
   
   $humidity = mysqli_real_escape_string($connection, $humidity);
   
   $query = mysqli_query($connection,"UPDATE humidity_fromWeb SET humidity='$humidity'");
?>