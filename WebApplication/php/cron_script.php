<?php

	// greenLab 
   	// A. Kubiček  |  V. Kaniok  |  M. Bernát
   	// php script
  
   $dbhost = "innodb.endora.cz";
   $dbuser = "";
   $dbpass = "";
   $dbname = "";
   
   $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

   $realTimeData = mysqli_query($connection, "SELECT * FROM realTime_fromPLC");
   $realTimeData = mysqli_fetch_row($realTimeData);
      
  $query = mysqli_query($connection,"INSERT INTO graphLog_web (temp, hum_out, hum_in, lux) VALUES ($realTimeData[0], $realTimeData[1], $realTimeData[2], $realTimeData[3])");

   $query_del = mysqli_query($connection,"DELETE FROM graphLog_web WHERE DateTime < (NOW() - INTERVAL 1 MONTH)");

?>