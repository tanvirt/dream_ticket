<!DOCTYPE html>
<?php require('add_courses.php'); ?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Dream Ticket | Courses</title>
	</head>
	<body>
		<div class="body">
			<h1>Dream Ticket</h1>
			Create a new course
			<form action="">
				<input type="text" name="course_code" placeholder="Course Code"/>
				<input type="text" name="title" placeholder="Course Title"/>
				<input type="submit" value="Create Course"/>
			</form>
			
			<br/>
			Add a course
			<br/><br/>
			<form action="">
				<?php display_all_courses($stmt) ?>
			</form>
		<div>
		<script type="text/javascript" src="xmlhttp.js"></script>
		<script type="text/javascript" src="login_signup.js"></script>
	</body>
</html>