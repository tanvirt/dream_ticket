<?php

session_start();

if(!isset($_SESSION['username']))
	die('You must be logged in to access this page<br/>'."<a href='login.html'>Click here</a> to log in");

$db = json_decode(file_get_contents("../db.json"));
$dbh = new PDO('pgsql:host='.$db->{'host'}.';port='.$db->{'port'}.';dbname='.$db->{'dbname'}.';user='.$db->{'user'}.';password='.$db->{'password'})
	or die('Could not connect to database');

$username = $_SESSION['username'];

$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];

$query = 'SELECT password_hash
			FROM accounts
			WHERE username = :username';
$stmt = $dbh->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->execute();
$row = $stmt->fetch();

$password_hash = $row['password_hash'];
$new_password_hash = password_hash($new_password, PASSWORD_BCRYPT);

function is_valid_input($new_password, $current_password, $password_hash) {
	return strlen($new_password) < 61 && password_verify($current_password, $password_hash);
}

function output_errors($new_password, $current_password, $password_hash) {
	$limit = 'cannot exceed 60 characters';
	if(strlen($new_password) > 60)
		echo 'Password ' .$limit. '<br/>';
	if(!password_verify($current_password, $password_hash))
		echo 'That is not the correct current password';
}

if(is_valid_input($new_password, $current_password, $password_hash)) {
	$query2 = 'UPDATE accounts
				SET password_hash = :new_password_hash
				WHERE username = :username';
	$stmt2 = $dbh->prepare($query2);
	$stmt2->bindParam(':new_password_hash', $new_password_hash);
	$stmt2->bindParam(':username', $username);
	$stmt2->execute();
	
	echo 'Password changed';
}
else
	echo output_errors($new_password, $current_password, $password_hash);

$dbh = null;