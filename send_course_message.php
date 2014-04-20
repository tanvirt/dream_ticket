<?php

session_start();

if(!isset($_SESSION['username']))
	die('You must be logged in to access this page<br/>'."<a href='login.html'>Click here</a> to log in");

$db = json_decode(file_get_contents("../db.json"));
$dbh = new PDO('pgsql:host='.$db->{'host'}.';port='.$db->{'port'}.';dbname='.$db->{'dbname'}.';user='.$db->{'user'}.';password='.$db->{'password'})
	or die('Could not connect to database');

$username = $_SESSION['username'];
$course_code = $_GET['value'];
$message = htmlspecialchars($_GET['message']);

$query = 'INSERT INTO course_messages (username, course_code, message)
			VALUES (:username, :course_code, :message)';
$stmt = $dbh->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':course_code', $course_code);
$stmt->bindParam(':message', $message);
$stmt->execute();

$dbh = null;