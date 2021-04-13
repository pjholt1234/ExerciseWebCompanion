<?php
session_start();
//include dbconnection
include ('dbcon.php');

//Get user id from session.
$userID = $_SESSION['id'];

//Assign variables from posted values
$newCat = $_POST['newCat'];
$newCatDesc = $_POST['newCatDesc'];
$newWorkout = $_POST['newWorkout'];
$newWorkoutDesc = $_POST['newWorkoutDesc'];
$newMeasurement = $_POST['newMeasurement'];


//Create Query to sent to db for new cat
$sql = "INSERT INTO categories (catagory_name, catagory_desc, user_made, user_ID) values ('$newCat','$newCatDesc','1', '$userID');";

//Send Query
mysqli_query($con,$sql);

//find last inserted ID
$last_id = $con->insert_id;

//Create Query to sent to db for new workout
$sql = "INSERT INTO workouts (workout_name, workout_desc, user_ID, user_made, catagory_ID, repstime) values ('$newWorkout','$newWorkoutDesc','$userID', '1','$last_id','$newMeasurement');";

//Send Query
mysqli_query($con,$sql);

//return to home
header("location:planaworkout.php?submit=success");
?>