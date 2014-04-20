<?php

$db = json_decode(file_get_contents("../db.json"));
$dbh = new PDO('pgsql:host='.$db->{'host'}.';port='.$db->{'port'}.';dbname='.$db->{'dbname'}.';user='.$db->{'user'}.';password='.$db->{'password'})
	or die('Could not connect to database');

$group_name = $_GET['group_name'];	

$query = "SELECT username, message, 
				TO_CHAR(time_posted, 'Mon dd') AS date, EXTRACT(HOUR FROM time_posted) AS hour, EXTRACT(MINUTE FROM time_posted) AS minute
			FROM group_messages
			WHERE group_name = :group_name
			ORDER BY id DESC";
$stmt = $dbh->prepare($query);
$stmt->bindParam(':group_name', $group_name);
$stmt->execute();

$message = $stmt->fetch();

function display_message($message) {
	$minute = '0';
	$hour = '';
	if($message['minute'] < 10)
		$minute .= $message['minute'];
	else
		$minute = ''.$message['minute'];
	if($message['hour'] > 12) {
		$hour .= ($message['hour'] - 12);
		$minute .= 'pm';
	}
	else {
		$hour .= $message['hour'];
		$minute .= 'am';
	}
	echo '<div class="message-box">';
	echo '<button class="button8" type="button" disabled>' 
			. $message['username'] . ' | ' 
			. $message['date'] . ' | '
			. $hour . ':'
			. $minute
			. '</button>';
	echo '<br/><br/>'.$message['message'].'<br/><br/>';
	echo '</div>';
}

if($message) {
	display_message($message);
	
	while($message = $stmt->fetch()) {
		display_message($message);
	}
}
else
	echo 'No messages';

$dbh = null;