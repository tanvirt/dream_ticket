<?php

$db = json_decode(file_get_contents("../db.json"));
$dbh = new PDO('pgsql:host='.$db->{'host'}.';port='.$db->{'port'}.';dbname='.$db->{'dbname'}.';user='.$db->{'user'}.';password='.$db->{'password'})
	or die('Could not connect to database');

$username = htmlspecialchars($_POST['username']);
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];
$first_name = htmlspecialchars($_POST['first_name']);
$last_name = htmlspecialchars($_POST['last_name']);

$query = 'SELECT username
			FROM accounts
			WHERE username = :username';
$stmt = $dbh->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->execute();

$user_exists = $stmt->fetch();

function is_valid_input($user_exists, $username, $password1, $password2, $first_name, $last_name) {
	return strlen($username) < 61 && strlen($password1) < 61 && strlen($first_name) < 61 && strlen($last_name) < 61 && !$user_exists && $password1 == $password2 && ctype_alpha($first_name . $last_name);
}

function output_errors($user_exists, $username, $password1, $password2, $first_name, $last_name) {
	$limit = 'cannot exceed 60 characters';
	if(strlen($username) > 60)
		echo 'Username ' .$limit. '<br/>';
	if(strlen($password1) > 60)
		echo 'Password ' .$limit. '<br/>';
	if(strlen($first_name) > 60)
		echo 'First name ' .$limit. '<br/>';
	if(strlen($last_name) > 60)
		echo 'Last name ' .$limit. '<br/>';
	if($user_exists)
		echo 'The username you entered already exists<br/>';
	if($password1 != $password2)
		echo 'The passwords you entered were not identical<br/>';
	if(!ctype_alpha($first_name . $last_name))
		echo 'First name and last name must contain only letters<br/>';
}

if(is_valid_input($user_exists, $username, $password1, $password2, $first_name, $last_name)) {
	$password_hash = password_hash($password1, PASSWORD_BCRYPT);
	
	$insert = 'INSERT INTO accounts (username, password_hash, first_name, last_name)
				VALUES (:username, :password_hash, :first_name, :last_name)';
	$stmt = $dbh->prepare($insert);
	$stmt->bindParam(':username', $username);
	$stmt->bindParam(':password_hash', $password_hash);
	$stmt->bindParam(':first_name', $first_name);
	$stmt->bindParam(':last_name', $last_name);
	$stmt->execute();
	
	echo 'Sign up was successful!';
}
else {
	output_errors($user_exists, $username, $password1, $password2, $first_name, $last_name);
}

$dbh = null;