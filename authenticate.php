<?php
session_start();
include ('dbcon.php');

// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if ( !isset($_POST['user_name'], $_POST['user_pass']) ) {
	// Could not get the data that should have been sent.
	exit('Please fill both the username and password fields!');
}
$sql ="SELECT user_ID, user_pass FROM userprofile WHERE user_name = ?";

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $con->prepare($sql)) {

	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$stmt->bind_param('s', $_POST['user_name']);
	$stmt->execute();
	// Store the result so we can check if the account exists in the database.
	$stmt->store_result();


	if ($stmt->num_rows > 0) {
	$stmt->bind_result($user_ID, $user_pass);
	$stmt->fetch();

	$result = $stmt->get_result();

	// Account exists, now we verify the password.
	// Note: remember to use password_hash in your registration file to store the hashed passwords.
	if (password_verify($_POST['user_pass'], $user_pass)) {
		// Verification success! User has logged-in!
		// Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
		session_regenerate_id();
		$_SESSION['loggedin'] = TRUE;
		$_SESSION['name'] = $_POST['user_name'];
		$_SESSION['id'] = $user_ID;
		header('Location: home.php');
	} else {
		// Incorrect password
		echo 'Incorrect password!';
	}
	} else {
	// Incorrect username
	echo 'Incorrect username and/or password!';
	}

	$stmt->close();
}
 ?>