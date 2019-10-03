<?php

	// greenLab 
   // A. Kubiček  |  V. Kaniok  |  M. Bernát
   // php script

	session_start();
	$error=''; 
	if (isset($_POST['submit'])) {
		if (empty($_POST['username']) || empty($_POST['password'])) {
			$error = "Username or Password is invalid";
		}
		else
		{
			$username=$_POST['username'];
			$password=$_POST['password'];
			$connection = mysqli_connect("innodb.endora.cz", "kaniok1", "heslo123", "comp");

			$username = stripslashes($username);
			$password = stripslashes($password);
			$username = mysqli_real_escape_string($connection, $username);
			$password = mysqli_real_escape_string($connection, $password);

			$query = mysqli_query($connection,"select * from login where password='$password' AND username='$username'");
			$rows = mysqli_num_rows($query);

			if ($rows == 1) {
				$_SESSION['login_user']=$username; // Initializing Session
				header("location: dashboard.php"); // Redirecting To Other Page
			} else {
				$error = "Špatně zadané uživatelské jméno nebo heslo";
			}

			mysqli_close($connection); // Closing Connection
		}
	}
	
?>