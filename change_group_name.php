<?php

session_start();

if(!isset($_SESSION['username']))
	die('You must be logged in to access this page<br/>'."<a href='login.html'>Click here</a> to log in");

$db = json_decode(file_get_contents("../db.json"));
$dbh = new PDO('pgsql:host='.$db->{'host'}.';port='.$db->{'port'}.';dbname='.$db->{'dbname'}.';user='.$db->{'user'}.';password='.$db->{'password'})
	or die('Could not connect to database');

$username = $_SESSION['username'];
$group_name = $_GET['group_name'];
$new_group_name = htmlspecialchars($_GET['new_group_name']);

$query = 'SELECT group_name
			FROM groups
			WHERE group_name = :new_group_name';
$stmt = $dbh->prepare($query);
$stmt->bindParam(':new_group_name', $new_group_name);
$stmt->execute();
$group_exists = $stmt->fetch();

if(!$group_exists && strlen($new_group_name) < 61) {
	$query2 = 'UPDATE groups
				SET group_name = :new_group_name
				WHERE owner = :username
					AND group_name = :group_name';
	$stmt2 = $dbh->prepare($query2);
	$stmt2->bindParam(':new_group_name', $new_group_name);
	$stmt2->bindParam(':username', $username);
	$stmt2->bindParam(':group_name', $group_name);
	$stmt2->execute();
	
	echo 'The new group name is: '.$new_group_name;
}
else {
	if($group_exists)
		echo 'That group name already exists';
	if(strlen($new_group_name > 60))
		echo 'Group name cannot exceed 60 characters';
}

$dbh = null;