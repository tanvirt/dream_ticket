<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8"/>
		<title>Dream Ticket | Account Deleted</title>
		<link rel="stylesheet" type="text/css" href="login_signup.css"/>
	</head>
	<body>
		<div class="body">
			<?php

			session_start();

			if(!isset($_SESSION['username']))
				die('You must be logged in to access this page<br/>'."<a href='login.html'>Click here</a> to log in");

			$db = json_decode(file_get_contents("../db.json"));
			$dbh = new PDO('pgsql:host='.$db->{'host'}.';port='.$db->{'port'}.';dbname='.$db->{'dbname'}.';user='.$db->{'user'}.';password='.$db->{'password'})
				or die('Could not connect to database');

			$username = $_SESSION['username'];

			$query = 'DELETE FROM accounts
						WHERE username = :username';
			$stmt = $dbh->prepare($query);
			$stmt->bindParam(':username', $username);
			$stmt->execute();
			
			session_destroy();
			
			echo "Your account has been deleted. <br/><a href='login.html'>Click here</a> to return to the login page";
			
			$dbh = null;
			
			?>
		</div>
	</body>
<html>