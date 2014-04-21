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
			WHERE username = :username
			ORDER BY course_code ASC';
$stmt = $dbh->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->execute();
$row = $stmt->fetch();

if($row) {
	echo '<option class="button2" value=\''.$row['course_code'].'\'>'.$row['course_code'].'</option>';
	while($row = $stmt->fetch())
		echo '<option class="button2" value=\''.$row['course_code'].'\'>'.$row['course_code'].'</option>';
}
else
	echo '<option class="button2" value="">None</option>';

$dbh = null;