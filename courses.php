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
			<a href="logout.php">Logout</a>
			
			<br/><br/>
			Create a new course
			<form action="" onsubmit="create_course(this.course_code.value, this.title.value)">
				<input type="text" name="course_code" placeholder="Course Code"/>
				<input type="text" name="title" placeholder="Course Title"/>
				<input type="submit" value="Create Course"/><!-- try onclick="function(this.parent.course_code.value)" -->
				<div id="create_response"></div>
			</form>
			
			<br/>
			Find a course
			<form action="" onsubmit="find_course(this.course_code.value)">
				<input type="text" name="course_code" placeholder="Course Code"/>
				<input type="submit" value="Find Course"/>
				<div id="find_response"></div>
			</form>
			
			<br/>
			Available courses
			<form action="">
				<?php display_all_courses($stmt, $table) ?>
			</form>
		<div>
		<script type="text/javascript" src="xmlhttp.js"></script>
		<script type="text/javascript" src="login_signup.js"></script>
	</body>
</html>