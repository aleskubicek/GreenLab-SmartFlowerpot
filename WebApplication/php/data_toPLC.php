<?php

   // greenLab 
   // A. Kubiček  |  V. Kaniok  |  M. Bernát
   // php script
  
   $dbhost = "innodb.endora.cz";
   $dbuser = "";
   $dbpass = "";
   $dbname = "";
   
   $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

   $hum_sql = mysqli_query($connection, "SELECT * FROM humidity_fromWeb");
   $hum_sql = mysqli_fetch_row($hum_sql);

   $light_sql = mysqli_query($connection, "SELECT * FROM light_fromWeb");
   $light_sql = mysqli_fetch_row($light_sql);

   $lux_sql = mysqli_query($connection, "SELECT * FROM lux_fromWeb");
   $lux_sql = mysqli_fetch_row($lux_sql);

   $rgb_sql = mysqli_query($connection, "SELECT * FROM rgb_fromWeb");
   $rgb_sql = mysqli_fetch_row($rgb_sql);

   $humidity = $hum_sql[0];
   $light_switch = $light_sql[0];
   $act_light = $light_sql[3];
   if ($light_switch == '1' && $act_light == '1') {
      $light = 1;
   } else {
      $light = 0;
   }
   $lux = $lux_sql[0];
   $red = $rgb_sql[0];
   $green = $rgb_sql[1];
   $blue = $rgb_sql[2];


   echo "<hum>";
   echo $humidity;
   echo "<lig>";
   echo $light;
   echo "<lux>";
   echo $lux;
   echo "<red>";
   echo $red;
   echo "<gre>";
   echo $green;
   echo "<blu>";
   echo $blue;
echo "</blu>";


?>