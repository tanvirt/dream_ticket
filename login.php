<?php

session_start();

$db = json_decode(file_get_contents("../db.json"));			
$dbh = new PDO('pgsql:host='.$db->{'host'}.';port='.$db->{'port'}.';dbname='.$db->{'dbname'}.';user='.$db->{'user'}.';password='.$db->{'password'})
	or die('Could not connect to database');

$username = htmlspecialchars($_POST['username']);
$password = $_POST['password'];

$query = 'SELECT username, password_hash 
			FROM accounts
			WHERE username = :username';
$stmt = $dbh->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->execute();
$row = $stmt->fetch();

$user = $row['username'];
$password_hash = $row['password_hash'];

function output_success($username) {
	echo 	"Welcome $username!<br/><br/>";
	echo	"<a href='profile_page.php'>Access your profile</a>";
}

if($user && password_verify($password, $password_hash)) {
	output_success($username);
	$_SESSION['username'] = $username;
}
else {
	echo 'Invalid username and password combination';
}

$dbh = null;