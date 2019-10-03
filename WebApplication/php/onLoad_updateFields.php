<?php

   // greenLab 
   // A. Kubiček  |  V. Kaniok  |  M. Bernát
   // php script
  
   $dbhost = "innodb.endora.cz";
   $dbuser = "";
   $dbpass = "";
   $dbname = "";
   
   $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

   //SELECT rgb
   $rgb = mysqli_query($connection, "SELECT * FROM rgb_fromWeb");
   $rgb = mysqli_fetch_row($rgb);

   //SELECT humidity
   $humidity = mysqli_query($connection, "SELECT humidity FROM humidity_fromWeb");
   $humidity = mysqli_fetch_row($humidity);

   //SELECT lux
   $lux = mysqli_query($connection, "SELECT lux FROM lux_fromWeb");
   $lux = mysqli_fetch_row($lux);

   //SELECT light
   $light = mysqli_query($connection, "SELECT * FROM light_fromWeb");
   $light = mysqli_fetch_row($light);

   $array_ofResults = array($rgb[0], $rgb[1], $rgb[2], $humidity[0], $lux[0], $light[0], $light[1], $light[2]);
   echo json_encode($array_ofResults);
?>