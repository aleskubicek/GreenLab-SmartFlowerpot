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
      
      $temp = $realTimeData[1];

	$ch = curl_init("https://fcm.googleapis.com/fcm/send");
	$header=array('Content-Type: application/json',
	"Authorization: key=AAAACWJmjWo:APA91bGD_CJVeSD2u3Hpl-2YQpJSjC1r9KN3DXiI0Vr__37ioR-ot43L8Rz0kz2tm6BRx_oaGqNsBnX2Vsndzso0A4EU2-34zFnltSq3r0h3Tq0AP2lI_cZNMiMeUomR8tYG3Bz2V5kE");
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "{ \"notification\": {    \"title\": \"greenLab - Varování!\",    \"text\": \"Vlhkost okolí: " . $temp/10 ."%\"  },    \"to\" : \"/topics/greenLab\"}");

	curl_exec($ch);
	curl_close($ch);

?>