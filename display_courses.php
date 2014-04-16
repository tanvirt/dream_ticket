<?php

session_start();

if(!isset($_SESSION['username']))
	die('You must be logged in to access this page<br/>'."<a href='login.html'>Click here</a> to log in");

$db = json_decode(file_get_contents("../db.json"));
$dbh = new PDO('pgsql:host='.$db->{'host'}.';port='.$db->{'port'}.';dbname='.$db->{'dbname'}.';user='.$db->{'user'}.';password='.$db->{'password'})
	or die('Could not connect to database');

$username = $_SESSION['username'];

$query = 'SELECT course_code
			FROM user_courses
			WHERE username = :username';
$stmt = $dbh->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->execute();

function display_user_courses($stmt) {
	if(!($row = $stmt->fetch())) {
		echo '<br/>No courses added. '."<a href='courses.php'>".'Click here</a> to add a course';
		return;
	}
	else {
		echo '<br/><input type="button" value='.$row['course_code'].' onclick="display_groups(this.value)">';
		while($row = $stmt->fetch()) {
			echo '<br/><input type="button" value='.$row['course_code'].' onclick="display_groups(this.value)">';
		}
		echo '<form action="courses.php">';
			echo '<input type="submit" value="Add Course">';
		echo '</form>';
	}
}

$dbh = null;