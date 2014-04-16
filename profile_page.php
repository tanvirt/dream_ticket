<!DOCTYPE html>
<?php require('display_courses.php'); ?>
<html lang="en">
	<head>
		<meta charset="UTF-8"/>
		<title>Dream Ticket | Profile Page</title>
	</head>
	<body>
		<div class="body">
			Hello <?php echo $username; ?>! <br/>
			
			<a href="logout.php">Logout</a>
			
			<div class="form>
				<form action="">
					<?php display_courses($stmt) ?>
				</form>
			</div>
			
			<div id="groups"></div>
		</div>
		<script type="text/javascript" src="xmlhttp.js"></script>
		<script type="text/javascript" src="login_signup.js"></script>
	</body>
</html>