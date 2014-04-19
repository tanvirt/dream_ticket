<?php

session_start();

if(!isset($_SESSION['username']))
	die('You must be logged in to access this page<br/>'."<a href='login.html'>Click here</a> to log in");

$db = json_decode(file_get_contents("../db.json"));
$dbh = new PDO('pgsql:host='.$db->{'host'}.';port='.$db->{'port'}.';dbname='.$db->{'dbname'}.';user='.$db->{'user'}.';password='.$db->{'password'})
	or die('Could not connect to database');

$username = $_SESSION['username'];

$query = 'SELECT group_name
			FROM user_groups
			WHERE username = :username';
$stmt = $dbh->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->execute();

while($row = $stmt->fetch()) {
	echo '<input type="button" value='.$row['group_name'].'><br/>';
}

$dbh = null;