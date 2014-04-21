<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8"/>
		<title>Dream Ticket | Logged Out</title>
		<link rel="stylesheet" type="text/css" href="login_signup.css"/>
	</head>
	<body>
		<?php

		session_start();

		session_destroy();
		
		echo "You have been logged out. <a href='login.html'>Click here</a> to log back in";
		
		?>
	</body>
<html>

