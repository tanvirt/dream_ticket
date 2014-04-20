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
			WHERE username = :username
			ORDER BY group_name ASC';
$stmt = $dbh->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->execute();
$row = $stmt->fetch();

//<option class="button2" value=""></option>

if($row) {
	echo '<option class="button2" value=\''.$row['group_name'].'\'>'.$row['group_name'].'</option>';
	while($row = $stmt->fetch())
		echo '<option class="button2" value=\''.$row['group_name'].'\'>'.$row['group_name'].'</option>';
}
else
	echo '<option class="button2" value="">None</option>';

$dbh = null;