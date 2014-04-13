<!DOCTYPE html>
<?php require('profile_functions.php'); ?>
<html lang="en">
	<head>
		<meta charset="UTF-8"/>
		<title>Dream Ticket | Profile Page</title>
	</head>
	<body>
		<div>
			Hello <?php echo $username; ?> <br/>
			
			<a href="logout.php">Logout</a>
			
			<?php display_courses($stmt) ?>
			
			<?php display_groups($stmt2) ?>
		</div>
	</body>
</html>