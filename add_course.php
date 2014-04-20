<?php

session_start();

$db = json_decode(file_get_contents("../db.json"));
$dbh = new PDO('pgsql:host='.$db->{'host'}.';port='.$db->{'port'}.';dbname='.$db->{'dbname'}.';user='.$db->{'user'}.';password='.$db->{'password'})
	or die('Could not connect to database');

$username = $_SESSION['username'];
$course_code = $_GET['course_code'];
	
$query = 'SELECT *
			FROM user_courses
			WHERE username = :username
				AND course_code = :course_code';
$stmt = $dbh->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':course_code', $course_code);
$stmt->execute();
$course_exists = $stmt->fetch();

if(!$course_exists) {
	$query2 = 'INSERT INTO user_courses (username, course_code)
				VALUES (:username, :course_code)';
	$stmt2 = $dbh->prepare($query2);
	$stmt2->bindParam(':username', $username);
	$stmt2->bindParam(':course_code', $course_code);
	$stmt2->execute();
	
	echo 'Course Added!';
}
else
	echo '"'.$course_code.'"'.' was already added to your account';

$dbh = null;