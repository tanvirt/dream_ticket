<?php

session_start();

$db = json_decode(file_get_contents("../db.json"));
$dbh = new PDO('pgsql:host='.$db->{'host'}.';port='.$db->{'port'}.';dbname='.$db->{'dbname'}.';user='.$db->{'user'}.';password='.$db->{'password'})
	or die('Could not connect to database');

$username = $_SESSION['username'];
$course_code = htmlspecialchars($_GET['course_code']);
$group_name = htmlspecialchars($_GET['group_name']);
$description = htmlspecialchars($_GET['description']);

$query = 'SELECT group_name
			FROM groups
			WHERE group_name = :group_name';
$stmt = $dbh->prepare($query);
$stmt->bindParam(':group_name', $group_name);
$stmt->execute();
$group_exists = $stmt->fetch();

$query2 = 'SELECT course_code
			FROM courses
			WHERE course_code = :course_code';
$stmt2 = $dbh->prepare($query2);
$stmt2->bindParam(':course_code', $course_code);
$stmt2->execute();
$course_exists = $stmt2->fetch();

if($group_exists || !$course_exists || strlen($group_name) > 60) {
	if($group_exists)
		echo 'That group name already exists<br/>';
	if(!$course_exists)
		echo 'That course does not exist<br/>';
	if(strlen($group_name) > 60)
		echo 'Group name cannot exceed 60 characters<br/>';
}
else {
	if($description == '') {
		$description = 'None';
	}
	$query3 = 'INSERT INTO course_groups (username, course_code, group_name, description)
				VALUES (:username, :course_code, :group_name, :description)';
	$stmt3 = $dbh->prepare($query3);
	$stmt3->bindParam(':username', $username);
	$stmt3->bindParam(':course_code', $course_code);
	$stmt3->bindParam(':group_name', $group_name);
	$stmt3->bindParam(':description', $description);
	$stmt3->execute();
	
	echo 'Group was created and added to your account!';
}

$dbh = null;