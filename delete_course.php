<?php

session_start();

if(!isset($_SESSION['username']))
	die('You must be logged in to access this page<br/>'."<a href='login.html'>Click here</a> to log in");

$db = json_decode(file_get_contents("../db.json"));
$dbh = new PDO('pgsql:host='.$db->{'host'}.';port='.$db->{'port'}.';dbname='.$db->{'dbname'}.';user='.$db->{'user'}.';password='.$db->{'password'})
	or die('Could not connect to database');

$username = $_SESSION['username'];
$course_code = $_GET['course_code'];

$query = 'DELETE FROM user_courses
			WHERE username = :username
				AND course_code = :course_code';
$stmt = $dbh->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':course_code', $course_code);
$stmt->execute();

$query2 = 'DELETE FROM user_groups
			WHERE username = :username
				AND group_name IN (SELECT group_name
									FROM course_groups NATURAL JOIN user_groups
									WHERE username = :username
										AND course_code = :course_code)';
$stmt2 = $dbh->prepare($query2);
$stmt2->bindParam(':username', $username);
$stmt2->bindParam(':course_code', $course_code);
$stmt2->execute();

$query3 = 'DELETE FROM groups
			WHERE owner = :username
				AND course_code = :course_code';
$stmt3 = $dbh->prepare($query3);
$stmt3->bindParam(':username', $username);
$stmt3->bindParam(':course_code', $course_code);
$stmt3->execute();

echo $course_code . ' and related groups were deleted';

$dbh = null;