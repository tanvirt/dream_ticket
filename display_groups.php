<?php

session_start();

if(!isset($_SESSION['username'])) 
	die('Please log in to access your profile page<br/>'."<a href='login.html'>Click here</a> to log in");

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

while($row = $stmt->fetch()) {
	echo '<input type="button" value='.$row['group_name'].'>';
}

$dbh = null;