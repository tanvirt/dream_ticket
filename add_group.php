<?php

session_start();

$db = json_decode(file_get_contents("../db.json"));
$dbh = new PDO('pgsql:host='.$db->{'host'}.';port='.$db->{'port'}.';dbname='.$db->{'dbname'}.';user='.$db->{'user'}.';password='.$db->{'password'})
	or die('Could not connect to database');

$username = $_SESSION['username'];
$course_code = $_GET['course_code'];
$group_name = $_GET['group_name'];

$query = 'SELECT group_name
			FROM user_groups
			WHERE username = :username
				AND group_name = :group_name';
$stmt = $dbh->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':group_name', $group_name);
$stmt->execute();
$group_exists = $stmt->fetch();

$query2 = 'SELECT course_code
			FROM user_courses
			WHERE username = :username
				AND course_code = :course_code';
$stmt2 = $dbh->prepare($query2);
$stmt2->bindParam(':username', $username);
$stmt2->bindParam(':course_code', $course_code);
$stmt2->execute();
$course_exists = $stmt2->fetch();

if(!$group_exists && $course_exists) {
	$query2 = 'INSERT INTO user_groups (username, group_name)
				VALUES (:username, :group_name)';
	$stmt2 = $dbh->prepare($query2);
	$stmt2->bindParam(':username', $username);
	$stmt2->bindParam(':group_name', $group_name);
	$stmt2->execute();
	
	echo 'Group Added!';
}
elseif($group_exists)
	echo '"'.$group_name.'"'.' was already added to your account';
else
	echo 'You must add '.'"'.$course_code.'"'.' to your account';


$dbh = null;