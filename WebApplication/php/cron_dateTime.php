<?php
  
   // greenLab 
   // A. Kubiček  |  V. Kaniok  |  M. Bernát
   // php script

   $dbhost = "innodb.endora.cz";
   $dbuser = "";
   $dbpass = "";
   $dbname = "";
   
   $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

   $data = mysqli_query($connection, "SELECT * FROM light_fromWeb");
   $data = mysqli_fetch_row($data);

   $timeFrom = str_replace(':', '.', $data[1]);
   $timeTo = str_replace(':', '.', $data[2]);
   $currentTime = str_replace(':', '.', date('H:i'));

   $timeFrom = (float)$timeFrom;
   $timeTo = (float)$timeTo;
   $currentTime = (float)$currentTime;

   $calc_overNight = $timeTo - $timeFrom;

   if ($timeFrom == $timeTo) {
      $setLight = 1;
   } elseif ($calc_overNight > 0) {
      if ($currentTime >= $timeFrom && $currentTime <= $timeTo) {
         $setLight = 1;
      } else {
         $setLight = 0;
      }
   } else {
      if ($currentTime >= $timeFrom || $currentTime <= $timeTo) {
         $setLight = 1;
      } else {
         $setLight = 0;
      }
   }

   $query = mysqli_query($connection,"UPDATE light_fromWeb SET act_light='$setLight'");

   $alert_done_sql = mysqli_query($connection,"UPDATE mail_alert_log SET send='0'");

?>