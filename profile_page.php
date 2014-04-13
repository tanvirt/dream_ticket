<!DOCTYPE html>
<?php session_start(); ?>
<?php if(!isset($_SESSION['username'])) die('You must be logged in to access this page'); ?>
<html lang="en">
	<head>
		<meta charset="UTF-8"/>
		<title>Dream Ticket | Profile Page</title>
	</head>
	<body>
		<div>
			Hello <?php echo $_SESSION['username']; ?> <br/>
			<a href="logout.php">Logout</a>
		</div>
	</body>
</html>