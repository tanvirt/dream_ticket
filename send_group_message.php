<?php

session_start();

if(!isset($_SESSION['username']))
	die('You must be logged in to access this page<br/>'."<a href='login.html'>Click here</a> to log in");

$db = json_decode(file_get_contents("../db.json"));
$dbh = new PDO('pgsql:host='.$db->{'host'}.';port='.$db->{'port'}.';dbname='.$db->{'dbname'}.';user='.$db->{'user'}.';password='.$db->{'password'})
	or die('Could not connect to database');

$username = $_SESSION['username'];
$group_name = $_GET['value'];
$message = htmlspecialchars($_GET['message']);

$query = 'INSERT INTO group_messages (username, group_name, message)
			VALUES (:username, :group_name, :message)';
$stmt = $dbh->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':group_name', $group_name);
$stmt->bindParam(':message', $message);
$stmt->execute();

$dbh = null;