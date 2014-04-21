<?php

session_start();

if(!isset($_SESSION['username']))
	die('You must be logged in to access this page<br/>'."<a href='login.html'>Click here</a> to log in");

$db = json_decode(file_get_contents("../db.json"));
$dbh = new PDO('pgsql:host='.$db->{'host'}.';port='.$db->{'port'}.';dbname='.$db->{'dbname'}.';user='.$db->{'user'}.';password='.$db->{'password'})
	or die('Could not connect to database');

$username = $_SESSION['username'];

$current_username = htmlspecialchars($_POST['current_username']);
$new_username = htmlspecialchars($_POST['new_username']);

$query = 'SELECT username
			FROM accounts
			WHERE username = :new_username';
$stmt = $dbh->prepare($query);
$stmt->bindParam(':new_username', $new_username);
$stmt->execute();
$user_exists = $stmt->fetch();

function is_valid_input($user_exists, $username, $current_username) {
	return strlen($username) < 61  && !$user_exists && $current_username == $username;
}

function output_errors($user_exists, $username, $current_username) {
	$limit = 'cannot exceed 60 characters';
	if(strlen($username) > 60)
		echo 'Username ' .$limit. '<br/>';
	if($user_exists)
		echo 'The username you entered already exists<br/>';
	if($current_username != $username)
		echo 'That is not the correct current username';
}

if(is_valid_input($user_exists, $username, $current_username)) {
	$query2 = 'UPDATE accounts
				SET username = :new_username
				WHERE username = :username';
	$stmt2 = $dbh->prepare($query2);
	$stmt2->bindParam(':new_username', $new_username);
	$stmt2->bindParam(':username', $username);
	$stmt2->execute();
	
	echo 'Your new username is: '.$new_username;
}
else
	echo output_errors($user_exists, $username, $current_username);

$dbh = null;