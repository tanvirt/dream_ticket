<?php

session_start();

if(!isset($_SESSION['username']))
	die('You must be logged in to access this page<br/>'."<a href='login.html'>Click here</a> to log in");

$db = json_decode(file_get_contents("../db.json"));
$dbh = new PDO('pgsql:host='.$db->{'host'}.';port='.$db->{'port'}.';dbname='.$db->{'dbname'}.';user='.$db->{'user'}.';password='.$db->{'password'})
	or die('Could not connect to database');

$username = $_SESSION['username'];
$course_code = $_GET['course_code'];

$query = 'SELECT group_name
			FROM groups NATURAL JOIN user_groups
			WHERE username = :username
				AND course_code = :course_code';
$stmt = $dbh->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':course_code', $course_code);
$stmt->execute();

$add_group = 	'<form action="groups.php">
					<input type="button" value="Add Group">
				</form>';

if(!($row = $stmt->fetch())) {
	echo '<br/>'.$add_group;
}
else {
	echo '<br/><input type="button" value='.$row['group_name'].'>';
	while($row = $stmt->fetch()) {
		echo '<br/><input type="button" value='.$row['group_name'].'>';
	}
	echo '<br/>'.$add_group;
}

$dbh = null;