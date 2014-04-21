<?php

session_start();

if(!isset($_SESSION['username']))
	die('You must be logged in to access this page<br/>'."<a href='login.html'>Click here</a> to log in");

$db = json_decode(file_get_contents("../db.json"));
$dbh = new PDO('pgsql:host='.$db->{'host'}.';port='.$db->{'port'}.';dbname='.$db->{'dbname'}.';user='.$db->{'user'}.';password='.$db->{'password'})
	or die('Could not connect to database');

$username = $_SESSION['username'];
$group_name = $_GET['group_name'];

echo	'<button class="button3" type="button" disabled>'.$group_name.'</button><br/><br/>'
.	 	'<form>'
.			'<button class="button3" type="button" disabled>Change group name</button><br/><br/>'
.			'<input class="text" type="text" name="new_group_name" placeholder="New group name" required/>'
.			'<input class="button4" type="submit" value="Change"/>'
.		'</form><br/><br/>'
.	 	'<form>'
.			'<button class="button3" type="button" disabled>Change group description</button><br/><br/>'
.			'<textarea class="description" type="text" name="description"></textarea>'
.			'<input class="button4" type="submit" value="Change"/>'
.		'</form>';

$dbh = null;