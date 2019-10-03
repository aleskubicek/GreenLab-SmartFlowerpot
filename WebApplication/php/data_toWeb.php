<?php

	// greenLab 
   // A. Kubiček  |  V. Kaniok  |  M. Bernát
   // php script
  
   $dbhost = "innodb.endora.cz";
   $dbuser = "";
   $dbpass = "";
   $dbname = "";
   
   $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

   $data = mysqli_query($connection, "SELECT * FROM realTime_fromPLC");
   $data = mysqli_fetch_row($data);

   $array_ofResults = array($data[0], $data[1], $data[2], $data[3]);
   echo json_encode($array_ofResults);
?>