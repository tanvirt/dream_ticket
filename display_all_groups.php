<?php

$db = json_decode(file_get_contents("../db.json"));
$dbh = new PDO('pgsql:host='.$db->{'host'}.';port='.$db->{'port'}.';dbname='.$db->{'dbname'}.';user='.$db->{'user'}.';password='.$db->{'password'})
	or die('Could not connect to database');

$query = 'SELECT course_code, group_name
			FROM groups
			ORDER BY course_code, group_name ASC';
$stmt = $dbh->prepare($query);
$stmt->execute();

$table = '<table>
			<tr>
				<th>Course</th>
				<th>Group</th>
				<th></th>
			</tr>';

while($row = $stmt->fetch()) {
	$table .= '
		<tr>
			<td>'.$row['course_code'].'</td>
			<td>'.$row['group_name'].'</td>
			<td><input class="button6" type="button" value="Add" onclick="add_course(\''.$row['course_code'].'\', \''.$row['group_name'].'\')"></td>
		</tr>';
}
$table .= '</table>';
echo $table;

$dbh = null;