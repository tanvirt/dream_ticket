<?php

session_start();

if(!isset($_SESSION['username']))
	die('You must be logged in to access this page<br/>'."<a href='login.html'>Click here</a> to log in");

$db = json_decode(file_get_contents("../db.json"));
$dbh = new PDO('pgsql:host='.$db->{'host'}.';port='.$db->{'port'}.';dbname='.$db->{'dbname'}.';user='.$db->{'user'}.';password='.$db->{'password'})
	or die('Could not connect to database');

$username = $_SESSION['username'];

$query = 'SELECT course_code, title
			FROM courses
			ORDER BY course_code, title ASC';
$stmt = $dbh->prepare($query);
$stmt->execute();

$table = '<table>
			<tr>
				<th>Course Code</th>
				<th>Course Title</th>
				<th></th>
			</tr>';

function display_all_courses($stmt, $table) {
	while($row = $stmt->fetch()) {
		$table .= '
			<tr>
				<td>'.$row['course_code'].'</td>
				<td>'.$row['title'].'</td>
				<td><input type="button" value="Add"></td>
			</tr>';
	}
	$table .= '</table>';
	echo $table;
}

$dbh = null;