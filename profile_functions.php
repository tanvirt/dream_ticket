<?php 

session_start();

if(!isset($_SESSION['username'])) 
	die('Please log in to access your profile page<br/>'."<a href='login.html'>Click here</a> to log in");

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

function display_courses($stmt) {
	while($row = $stmt->fetch()) {
		echo '<br/>'.$row['course_code'];
	}
}

$query = 'SELECT group_name
			FROM user_groups
			WHERE username = :username';
$stmt2 = $dbh->prepare($query);
$stmt2->bindParam(':username', $username);
$stmt2->execute();

function display_groups($stmt2) {
	while($row = $stmt2->fetch()) {
		echo '<br/>'.$row['group_name'];
	}
}

$dbh = null;