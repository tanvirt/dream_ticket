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
$row = $stmt->fetch();

if($row) {
	echo '<input class="button2" type="button" value='.$row['course_code'].' 
				onclick="display_groups(\''.$row['course_code'].'\'); 
				document.getElementById(\'group_response\').style.display=\'block\';
				change_group_button(\''.$row['course_code'].'\')"><br/>';
	while($row = $stmt->fetch()) {
		echo '<input class="button2" type="button" value='.$row['course_code'].' 
				onclick="display_groups(\''.$row['course_code'].'\'); 
				document.getElementById(\'group_response\').style.display=\'block\';
				change_group_button(\''.$row['course_code'].'\')"><br/>';
	}
}
else
	echo '<input class="button2" type="button" value="None"><br/>';

$dbh = null;