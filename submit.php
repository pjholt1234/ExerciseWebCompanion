<?php
//open session to get user_ID
session_start();
//include dbconnection
include ('dbcon.php');

//Get user id from session.
$userID = $_SESSION['id'];

//Get todays day
$date = date("Y/m/d");

//Take the posted values from Plan a workout and assign them to two variables
$planname = $_POST['planName'];
$plans = json_decode($_POST['plans'],true);
$option =  $_POST['opt'];
if ($option == "Save") {
		//Create string for sql query for plans
	$sql = "INSERT INTO plans (user_ID, plan_name, plan_desc, last_used, user_made) values ('$userID','$planname','plan_desc', '$date', '1');";
	//run query
	mysqli_query($con,$sql);

	$last_id = $con->insert_id;
	foreach($plans as $inside_array) {

		$catagory_name = $inside_array['catagory_name'];
		$workout_name = $inside_array['workout_name'];
		$pieces = explode(":", $inside_array['unit']);
		$unit = $pieces[0];
		$amount = $inside_array['amount'];
		$weight = $inside_array['weight'];


		if($unit == "Duration"){

			//Create string for sql query for plans_workouts
			$sql = "INSERT INTO plans_workouts (plan_name, catagory_name, workout_name, unit, reps, weight, duration, plan_ID, user_ID) values ('$planname','$catagory_name','$workout_name','$unit','0','$weight','$amount','$last_id','$userID');";
		}else{

			//Create string for sql query for plans_workouts
			$sql = "INSERT INTO plans_workouts (plan_name, catagory_name, workout_name, unit, reps, weight, duration,plan_ID, user_ID) values ('$planname','$catagory_name','$workout_name','$unit','$amount','$weight','0','$last_id','$userID');";
		};
		//run query
		mysqli_query($con,$sql);
	};
}else{

	$ID=$_POST["str"]; 
	$sql = "DELETE FROM `plans` WHERE plan_ID = '$ID'";

	if ($con->query($sql) === TRUE) {
	  echo "Record deleted successfully";
	} else {
	  echo "Error deleting record: " . $conn->error;
	};
	
	$sql = "DELETE FROM `plans_workouts` WHERE plan_ID = '$ID'";

	if ($con->query($sql) === TRUE) {
	  echo "Record deleted successfully";
	} else {
	  echo "Error deleting record: " . $conn->error;
	};
};


//return to home
header("location:planaworkout.php?submit=success");
?>