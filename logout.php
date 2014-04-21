<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8"/>
		<title>Dream Ticket | Logged Out</title>
		<link rel="stylesheet" type="text/css" href="login_signup.css"/>
	</head>
	<body>
		<div class="body">
			<?php

			session_start();
			
			if(!isset($_SESSION['username']))
				die('You must be logged in to access this page<br/>'."<a href='login.html'>Click here</a> to log in");
			
			session_destroy();
			
			echo "You have been logged out. <a href='login.html'>Click here</a> to log back in";
			
			?>
		</div>
	</body>
<html>

