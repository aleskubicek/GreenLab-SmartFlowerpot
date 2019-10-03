<?php
include('php/login.php');

if(isset($_SESSION['login_user'])){
header("location: dashboard.php");
}

?>

<!DOCTYPE html>
<html>
<head>
	<!--                greenLab               -->    
	<!--                NAG  IoE               --> 
	<!--   A.Kubicek    V.Kaniok    M.Bernat   --> 
	<meta charset="utf-8">
	<title>greenLab</title>
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>

<body>
	<img src="img/greenLab_logo.png" class="img_logo">
	<div class="login-page">
	  <div class="form">
	    <form class="login-form" method="post">
	      <input type="text" placeholder="uživatel" name="username" id="name" value="Admin" />
	      <input type="password" placeholder="heslo" name="password" id="password" value="heslo123" />
	      <button name="submit" type="submit">Přihlášení</button>
	      <p class="message"><?php echo $error; ?></p>
	    </form>
	  </div>
	</div>
</body>
</html>