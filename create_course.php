<?php

$db = json_decode(file_get_contents("../db.json"));
$dbh = new PDO('pgsql:host='.$db->{'host'}.';port='.$db->{'port'}.';dbname='.$db->{'dbname'}.';user='.$db->{'user'}.';password='.$db->{'password'})
	or die('Could not connect to database');

$course_code = htmlspecialchars($_GET['course_code']);
$title = htmlspecialchars($_GET['title']);

$query = 'SELECT course_code
			FROM courses
			WHERE course_code = :course_code';
$stmt = $dbh->prepare($query);
$stmt->bindParam(':course_code', $course_code);
$stmt->execute();
$row = $stmt->fetch();

if($row || strlen($course_code) > 8 || strlen($course_code) < 7 || strlen($title) > 60 || !ctype_alnum($course_code)) {
	if($row)
		echo 'That course already exists<br/>';
	if(strlen($course_code) > 8)
		echo 'Course code cannot exceed 8 characters<br/>';
	if(strlen($course_code) < 7)
		echo 'Course code cannot be fewer than 7 characters<br/>';
	if(strlen($title) > 60)
		echo 'Course title cannot exceed 60 characters<br/>';
	if(!ctype_alnum($course_code))
		echo 'Course code can only contain letters and numbers (no whitespaces)<br/>';
}
else {
	$query2 = 'INSERT INTO courses (course_code, title)
				VALUES (:course_code, :title)';
	$stmt2 = $dbh->prepare($query2);
	$stmt2->bindParam(':course_code', $course_code);
	$stmt2->bindParam(':title', $title);
	$stmt2->execute();
	
	echo 'Course created!';
}

$dbh = null;