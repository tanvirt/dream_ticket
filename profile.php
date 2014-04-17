<!DOCTYPE html>
<?php require('user_courses.php'); ?>
<html lang="en">
	<head>
		<meta charset="UTF-8"/>
		<title>Dream Ticket | Profile Page</title>
		<link rel="stylesheet" type="text/css" href="login_signup.css"/>
	</head>
	<body>
		<div>
			<h1>Dream Ticket</h1>
			Hello <?php echo $username; ?>! <br/>
			
			<a href="logout.php">Logout</a>
			
			<br/><br/>
			Courses
			<form action="">
				<?php display_user_courses($stmt) ?>
			</form>
			<br/><a href='courses.php'>Add a course</a><br/>
			
			<br/>
			Groups
			<div id="groups"></div>
			<br/><a href='groups.php'>Add a group</a><br/>
		</div>
		<script type="text/javascript" src="xmlhttp.js"></script>
		<script type="text/javascript" src="login_signup.js"></script>
	</body>
</html>