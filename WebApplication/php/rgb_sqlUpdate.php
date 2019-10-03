<?php

   // greenLab 
   // A. Kubiček  |  V. Kaniok  |  M. Bernát
   // php script
  
   $dbhost = "innodb.endora.cz";
   $dbuser = "";
   $dbpass = "";
   $dbname = "";
   
   $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
      
   $red = $_GET['red'];
   $green = $_GET['green'];
   $blue = $_GET['blue'];
   
   $red = mysqli_real_escape_string($connection, $red);
   $green = mysqli_real_escape_string($connection, $green);
   $blue = mysqli_real_escape_string($connection, $blue);
   
   $query = mysqli_query($connection,"UPDATE rgb_fromWeb SET red='$red', green='$green', blue='$blue'");
?>