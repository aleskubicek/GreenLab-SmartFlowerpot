<?php

	// greenLab 
   // A. Kubiček  |  V. Kaniok  |  M. Bernát
   // php script

	session_start();
	if(session_destroy()) {
		header("Location: ../index.php"); 
	}
	
?>