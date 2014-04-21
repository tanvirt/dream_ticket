<?php

$db = json_decode(file_get_contents("../db.json"));
$dbh = new PDO('pgsql:host='.$db->{'host'}.';port='.$db->{'port'}.';dbname='.$db->{'dbname'}.';user='.$db->{'user'}.';password='.$db->{'password'})
	or die('Could not connect to database');

$username = htmlspecialchars($_POST['username']);
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];

$query = 'SELECT username
			FROM accounts
			WHERE username = :username';
$stmt = $dbh->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->execute();

$user_exists = $stmt->fetch();

function is_valid_input($user_exists, $username, $password1, $password2) {
	return strlen($username) < 61 && strlen($password1) < 61 && !$user_exists && $password1 == $password2;
}

function output_errors($user_exists, $username, $password1, $password2) {
	$limit = 'cannot exceed 60 characters';
	if(strlen($username) > 60)
		echo 'Username ' .$limit. '<br/>';
	if(strlen($password1) > 60)
		echo 'Password ' .$limit. '<br/>';
	if($user_exists)
		echo 'The username you entered already exists<br/>';
	if($password1 != $password2)
		echo 'The passwords you entered were not identical<br/>';
}

if(is_valid_input($user_exists, $username, $password1, $password2)) {
	$password_hash = password_hash($password1, PASSWORD_BCRYPT);
	
	$insert = 'INSERT INTO accounts (username, password_hash)
				VALUES (:username, :password_hash)';
	$stmt = $dbh->prepare($insert);
	$stmt->bindParam(':username', $username);
	$stmt->bindParam(':password_hash', $password_hash);
	$stmt->execute();
	
	echo 'Sign up was successful!';
}
else {
	output_errors($user_exists, $username, $password1, $password2);
}

$dbh = null;