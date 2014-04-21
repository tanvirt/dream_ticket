<?php

session_start();

if(!isset($_SESSION['username']))
	die('You must be logged in to access this page<br/>'."<a href='login.html'>Click here</a> to log in");

$db = json_decode(file_get_contents("../db.json"));
$dbh = new PDO('pgsql:host='.$db->{'host'}.';port='.$db->{'port'}.';dbname='.$db->{'dbname'}.';user='.$db->{'user'}.';password='.$db->{'password'})
	or die('Could not connect to database');

$username = $_SESSION['username'];
$account_option = $_GET['account_option'];

if($account_option == 'change_user') {
	echo 	'<form action="" onsubmit="change_username(this.current_username.value, this.new_username.value); return false;">'
	.			'<button class="button3" type="button" disabled>Change username</button><br/><br/>'
	.			'<input class="text" type="text" name="current_username" placeholder="Current username" required/>'
	.			'<input class="text" type="text" name="new_username" placeholder="New username" required/>'
	.			'&nbsp;&nbsp;<input class="button4" type="submit" value="Change"/>'
	.		'</form>';
}
else {
	echo 	'<form action="" onsubmit="change_password(this.current_password.value, this.new_password.value); return false;">'
	.			'<button class="button3" type="button" disabled>Change password</button><br/><br/>'
	.			'<input class="text" type="password" name="current_password" placeholder="Current password" required/>'
	.			'<input class="text" type="password" name="new_password" placeholder="New password" required/>'
	.			'&nbsp;&nbsp;<input class="button4" type="submit" value="Change"/>'
	.		'</form>';
}

$dbh = null;