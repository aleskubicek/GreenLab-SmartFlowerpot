<?php
  
   // greenLab 
   // A. Kubiček  |  V. Kaniok  |  M. Bernát
   // php script

   $dbhost = "innodb.endora.cz";
   $dbuser = "";
   $dbpass = "";
   $dbname = "";
   
   $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

   $alert_sql = mysqli_query($connection, "SELECT * FROM mail_alert_log");
   $alert_sql = mysqli_fetch_row($alert_sql);

   $box = $_GET['box'];
   $value = $_GET['value'];

   $box = mysqli_real_escape_string($connection, $box);
   $value = mysqli_real_escape_string($connection, $value);

   if ($box == "Teplota") {
      $unit = " °C";
   } elseif ($box == "Vlhkost_okoli") {
      $unit = " %";
   } elseif ($box == "Vlhkost_pudy") {
      $unit = " %";
   }

   if ($alert_sql[0] == 0) {
      $to      = 'kubicek.ales@outlook.com';
      $subject = 'Upozornění - ' . $box;
      $message = 'Hodnota přesáhla povolenou hranici!' . "\r\n" . $box . " = " . $value . $unit;
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
      $headers .= "From: greenLab@kvetinac.com" . "\r\n" .
      "Reply-To: greenLab@kvetinac.com" . "\r\n" .
      "X-Mailer: PHP/" . phpversion();

      mail($to, $subject, $message, $headers);
      $alert_done_sql = mysqli_query($connection,"UPDATE mail_alert_log SET send='1'");
      echo "mail";
   }

?>