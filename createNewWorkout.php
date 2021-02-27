<?php
session_start();
//include dbconnection
include ('dbcon.php');

//Get user id from session.
$userID = $_SESSION['id'];

//Assign variables from posted values
$catagoryName = $_POST['cat'];
$newWorkout = $_POST['newWorkout'];
$newWorkoutDesc = $_POST['newWorkoutDesc'];
$newMeasurement = $_POST['newMeasurement'];

//Create Query to sent to db for cat ID
$sql= "SELECT catagory_ID FROM categories WHERE catagory_name = '$catagoryName'";

//Get Result
$result = mysqli_query($con,$sql);

// Put result into array
while ( $row = $result->fetch_assoc()){
	$catArr[]=$row;
};

//get cat ID
$catID = $catArr[0]["catagory_ID"];

//Create Query to sent to db for new workout
$sql = "INSERT INTO workouts (workout_name, workout_desc, user_ID, user_made, catagory_ID, repstime) values ('$newWorkout','$newWorkoutDesc','$userID', '1','$catID','$newMeasurement');";

//Insert into DB
mysqli_query($con,$sql);

//return to home
header("location:planaworkout.php?submit=success");
?>