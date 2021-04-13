<?php
session_start();
//include dbconnection
include ('dbcon.php');

//Get user id from session.
$userID = $_SESSION['id'];
$date = date("Y-m-d h:i:sa");
$weight = $_POST['weight'];

$sql = "INSERT INTO weight (user_ID, weight, entry_date) values ('$userID','$weight','$date');";
	//run query
mysqli_query($con,$sql);
header("location:profile.php?submit=success");
?>