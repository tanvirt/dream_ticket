<?php
session_start();

if(!isset($_SESSION['username']))
	die('You must be logged in to access this page<br/>'."<a href='login.html'>Click here</a> to log in");

echo '<option value="change_user">Change username</option>';
echo '<option value="change_pass">Change password</option>';