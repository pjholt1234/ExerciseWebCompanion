<?php
session_start();
include ('dbcon.php');
$userID = $_SESSION['id'];
$monthGoalValue = $_POST['monthGoal'];
$weekGoalValue = $_POST['weekGoal'];

$sql = "UPDATE goals SET monthly_goal = '$monthGoalValue' WHERE user_ID = '$userID'";	
mysqli_query($con,$sql);

$sql = "UPDATE goals SET weekly_goal = '$weekGoalValue' WHERE user_ID = '$userID'";
//Send Query
mysqli_query($con,$sql);

header("location:profile.php?submit=success");
?>