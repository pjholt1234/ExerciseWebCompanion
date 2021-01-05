<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

$xmldata = simplexml_load_file("configHOME.xml") or die("Failed to load");
 	$host = $xmldata->data->servername;
    $user = $xmldata->data->username; 
    $password = $xmldata->data->password;
	$dbname = $xmldata->data->dbname;
    
$con= mysqli_connect($host,$user,$password,$dbname);
if (!$con)
{
    die("Unable to connect to the database". mysqli_connect_error());
}
// We don't have the password or email info stored in sessions so instead we can get the results from the database.
$stmt = $con->prepare('SELECT user_email, user_pass FROM userprofile WHERE user_ID = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($user_email, $user_pass);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Profile Page</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Exercise Web Companion</h1>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>Profile Page</h2>
			<div>
				<p>Your account details are below:</p>
				<table>
					<tr>
						<td>Username:</td>
						<td><?=$_SESSION['name']?></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><?=$user_pass?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?=$user_email?></td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>