<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Home Page</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Exercise Web Companion</h1>
				<a onclick="setURL('planaworkout.php')"><i class="fas fa-home"></i>Home</a>
				<a onclick="setURL('tips&tricks/tips&tricks.php')"><i class="fab fa-youtube"></i></i>Tips & Tricks</a>
				<a onclick="setURL('calendar/calendar.php')"><i class="far fa-calendar-plus"></i>Calendar</a>
				<a onclick="setURL('profile.php')"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<iframe src="planaworkout.php" id = "iframe" title="plan a workout"></iframe>
		</div>
	</body>
</html>
<script>
function setURL(url){
    document.getElementById('iframe').src = url;
}
</script>
