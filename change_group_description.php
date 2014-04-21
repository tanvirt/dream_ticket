<?php

session_start();

if(!isset($_SESSION['username']))
	die('You must be logged in to access this page<br/>'."<a href='login.html'>Click here</a> to log in");

$db = json_decode(file_get_contents("../db.json"));
$dbh = new PDO('pgsql:host='.$db->{'host'}.';port='.$db->{'port'}.';dbname='.$db->{'dbname'}.';user='.$db->{'user'}.';password='.$db->{'password'})
	or die('Could not connect to database');

$username = $_SESSION['username'];
$group_name = $_GET['group_name'];
$new_description = htmlspecialchars($_GET['new_description']);

$query = 'UPDATE groups
			SET description = :new_description
			WHERE owner = :username
				AND group_name = :group_name';
$stmt = $dbh->prepare($query);
$stmt->bindParam(':new_description', $new_description);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':group_name', $group_name);
$stmt->execute();

echo 'Group description for '.$group_name.' was changed';

$dbh = null;