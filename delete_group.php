<?php

session_start();

if(!isset($_SESSION['username']))
	die('You must be logged in to access this page<br/>'."<a href='login.html'>Click here</a> to log in");

$db = json_decode(file_get_contents("../db.json"));
$dbh = new PDO('pgsql:host='.$db->{'host'}.';port='.$db->{'port'}.';dbname='.$db->{'dbname'}.';user='.$db->{'user'}.';password='.$db->{'password'})
	or die('Could not connect to database');
	
$username = $_SESSION['username'];
$group_name = $_GET['group_name'];

$query = 'DELETE FROM course_groups
			WHERE username = :username
				AND group_name = :group_name';
$stmt = $dbh->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':group_name', $group_name);
$stmt->execute();

echo $group_name . ' has been deleted from your account';

$dbh = null;