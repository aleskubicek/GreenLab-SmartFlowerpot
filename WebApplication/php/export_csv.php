<?php

   // greenLab 
   // A. Kubiček  |  V. Kaniok  |  M. Bernát
   // php script

   $dbhost = "innodb.endora.cz";
   $dbuser = "";
   $dbpass = "";
   $dbname = "";
   
   $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

   $result = mysqli_query($connection, "SELECT * FROM graphLog_web");

      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=greenLab_data.csv');  
      $output = fopen("php://output", "w");  
      fputcsv($output, array('Datum/cas', 'Teplota', 'Vlhkost_okoli', 'Vlhkost_pudy', 'Intenzita_osvetleni'));  
      $result = mysqli_query($connection, "SELECT * FROM graphLog_web");
      while($row = mysqli_fetch_assoc($result))  
      {  
           fputcsv($output, $row);  
      }  
      fclose($output);  

?>