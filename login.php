<?php

$db = json_decode(file_get_contents("../db.json"));			
$dbh = new PDO('pgsql:host='.$db->{'host'}.';port='.$db->{'port'}.';dbname='.$db->{'dbname'}.';user='.$db->{'user'}.';password='.$db->{'password'});

$username = htmlspecialchars($_POST['username']);
$password = $_POST['password'];

$query = 'SELECT username, password_hash 
			FROM accounts
			WHERE username = :username';
$stmt = $dbh->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->execute();
$row = $stmt->fetch();

$user = $row[0];
$password_hash = $row[1];

function output_success() {
	echo 'You logged in!';
}

if($user && password_verify($password, $password_hash)) {
	output_success();
}
else {
	echo 'Invalid username and password combination';
}

$dbh = null;