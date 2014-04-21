<?php

$db = json_decode(file_get_contents("../db.json"));
$dbh = new PDO('pgsql:host='.$db->{'host'}.';port='.$db->{'port'}.';dbname='.$db->{'dbname'}.';user='.$db->{'user'}.';password='.$db->{'password'})
	or die('Could not connect to database');

$query = 'SELECT course_code, title, COUNT(username) AS count
			FROM courses NATURAL JOIN user_courses
			GROUP BY course_code
			ORDER BY course_code, title ASC';
$stmt = $dbh->prepare($query);
$stmt->execute();

$table = '<table>
			<tr>
				<th>Course Code</th>
				<th>Course Title</th>
				<th>Members</th>
				<th></th>
			</tr>';

//does not check if there aren't any courses available
while($row = $stmt->fetch()) {
	$table .= '
		<tr>
			<td>'.$row['course_code'].'</td>
			<td>'.$row['title'].'</td>
			<td>'.$row['count'].'</td>
			<td><input class="button6" type="button" value="Add" onclick="add_course(\''.$row['course_code'].'\');
					document.getElementById(\'create_response\').style.display=\'none\'; 
					document.getElementById(\'add_response\').style.display=\'block\'"></td>
		</tr>';
}
$table .= '</table>';
echo $table;

$dbh = null;