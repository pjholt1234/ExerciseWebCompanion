<?php
	// We need to use sessions, so you should always start sessions using the below code.
	session_start();
	// If the user is not logged in redirect to the login page...
	if (!isset($_SESSION['loggedin'])) {
		header('Location: index.html');
		exit;
	}
	include ('dbcon.php');
	// We don't have the password or email info stored in sessions so instead we can get the results from the database.
	$stmt = $con->prepare('SELECT user_email, user_pass FROM userprofile WHERE user_ID = ?');
	// In this case we can use the account ID to get the account info.
	$stmt->bind_param('i', $_SESSION['id']);
	$stmt->execute();
	$stmt->bind_result($user_email, $user_pass);
	$stmt->fetch();
	$stmt->close();

	$userID = $_SESSION['id'];

	// Connect to database
	include ('dbcon.php');

	//*--This is where all non time dependant stats are generated--*
	//Get Array of custom catagories from db
	$sql= "SELECT catagory_ID, catagory_name, catagory_desc FROM categories WHERE user_ID = '$userID'";
	$catTotal = getTotals($sql,$con);

	//Get custom workouts from db
	$sql = "SELECT * FROM workouts WHERE user_ID = '$userID'";
	$customWorkoutTotal = getTotals($sql,$con);
	
	//array of all custom plans.
	$sql = "SELECT * FROM plans WHERE user_ID = '$userID'";
	$plansTotal = getTotals($sql,$con);


	//array of workouts within plans
	$sql = "SELECT * FROM plans_workouts WHERE user_ID = '$userID'";
	$result = mysqli_query($con,$sql);

	//Fetch into associative array
	while ($row = $result->fetch_assoc()) {
		$userWorkoutsArr[] = $row;
	};

	//array of workouts within plans
	$sql = "SELECT * FROM plans_workouts";
	$result = mysqli_query($con,$sql);

	//Fetch into associative array
	while ($row = $result->fetch_assoc()) {
		$WorkoutsArr[] = $row;
	};



	//*--This is where all time dependant stats are generated--*
	//define todays date
	$today = date("Y/m/d");

	//define this month & year
	$month = date("m");
	$year = date("Y");

	//change to be all previous workouts

	//All Time stats
	$sql="SELECT * FROM events";
	$completedPlansTotal = getTotals($sql,$con);
	$compAllPlansArr = getArr($sql,$con);
	$workoutsTotal = getWorkoutTotal($sql,$con,$WorkoutsArr);
	$compAllWorkoutsArr = getArr($sql,$con);
	$favWorkoutAll = findFavWorkout($con,$sql,$WorkoutsArr);
	$catArrAll = getCategoryArr($con,$sql,$WorkoutsArr);
	$favCatAll = findFavCategory($catArrAll);
	$repsAll = getReps($con,$sql,$WorkoutsArr);
	$weightAll = getWeight($con,$sql,$WorkoutsArr);

	//and is less than today
	//Month stats
	$sql="SELECT * FROM events WHERE MONTH(end_event) = '$month' AND YEAR(end_event) = '$year'";
	$totalPlansMonth = getTotals($sql,$con);
	$compMonthPlansArr = getArr($sql,$con);
	$workoutsMonthTotal = getWorkoutTotal($sql,$con,$WorkoutsArr);
	$compMonthWorkoutsArr = getArr($sql,$con);
	$favWorkoutMonth = findFavWorkout($con,$sql,$WorkoutsArr);
	$catArrMonth = getCategoryArr($con,$sql,$WorkoutsArr);
	$favCatMonth = findFavCategory($catArrMonth);
	$repsMonth = getReps($con,$sql,$WorkoutsArr);
	$weightMonth = getWeight($con,$sql,$WorkoutsArr);

	//Week stats
	$sql="SELECT * FROM events WHERE end_event < DATE_SUB(NOW(), INTERVAL 1 WEEK)";
	$totalPlansWeek = getTotals($sql,$con);
	$compWeekPlansArr = getArr($sql,$con);
	$workoutsWeekTotal = getWorkoutTotal($sql,$con,$WorkoutsArr);
	$compWeekWorkoutsArr = getArr($sql,$con);
	$favWorkoutWeek = findFavWorkout($con,$sql,$WorkoutsArr);
	$catArrWeek = getCategoryArr($con,$sql,$WorkoutsArr);
	$favCatWeek = findFavCategory($catArrWeek);
	$repsWeek = getReps($con,$sql,$WorkoutsArr);
	$weightWeek = getWeight($con,$sql,$WorkoutsArr);

	function findFavWorkout($con,$sql,$WorkoutsArr){
		$result = mysqli_query($con,$sql);
		while ($row = $result->fetch_assoc()) {
			$events[] = $row;
		};

		$favWorkoutArr = Array();

		//check if either array is empty
		if(!empty($events) and !empty($WorkoutsArr)){
			//loop through events array
			for ($i=0; $i <count($events) ; $i++) {

				//loop through workouts array
				for ($x=0; $x <count($WorkoutsArr) ; $x++) { 
					//find matching plan ID's
					if ($events[$i]["plan_ID"] == $WorkoutsArr[$x]["plan_ID"]) {

						//if the array key exists add 1;
						if (array_key_exists($WorkoutsArr[$x]["workout_name"],$favWorkoutArr)){
							$favWorkoutArr[$WorkoutsArr[$x]["workout_name"]]++;
						}
						else{
						//if not create a new item with the key of the workout name and give it a value of 1;
						  $favWorkoutArr[$WorkoutsArr[$x]["workout_name"]] = 1;
						}

					}
				}
			}

			//Find the highest value in the array
			//by using PHP's max function.
			$maxVal = max($favWorkoutArr);

			//Use array_search to find the key that
			//the max value is associated with
			$maxKey = array_search($maxVal, $favWorkoutArr);
			return $maxKey;
		}else{
			return "None";
		};	
	};

	function getCategoryArr($con,$sql,$WorkoutsArr){
		$result = mysqli_query($con,$sql);
		while ($row = $result->fetch_assoc()) {
			$events[] = $row;
		};

		$favCategoryArr = Array();

		//check if either array is empty
		if(!empty($events) and !empty($WorkoutsArr)){
			//loop through events array
			for ($i=0; $i <count($events) ; $i++) {

				//loop through workouts array
				for ($x=0; $x <count($WorkoutsArr) ; $x++) { 
					//find matching plan ID's
					if ($events[$i]["plan_ID"] == $WorkoutsArr[$x]["plan_ID"]) {

						//if the array key exists add 1;
						if (array_key_exists($WorkoutsArr[$x]["catagory_name"],$favCategoryArr)){
							$favCategoryArr[$WorkoutsArr[$x]["catagory_name"]]++;
						}
						else{
						//if not create a new item with the key of the workout name and give it a value of 1;
						  $favCategoryArr[$WorkoutsArr[$x]["catagory_name"]] = 1;
						}

					}
				}
			}
			
			return $favCategoryArr;
		}else{
			return $favCategoryArr["None"] = "0";
		};	
	};

	function getReps($con,$sql,$WorkoutsArr){
		$result = mysqli_query($con,$sql);
		while ($row = $result->fetch_assoc()) {
			$events[] = $row;
		};

		$reps = 0;

		//check if either array is empty
		if(!empty($events) and !empty($WorkoutsArr)){
			//loop through events array
			for ($i=0; $i <count($events) ; $i++) {

				//loop through workouts array
				for ($x=0; $x <count($WorkoutsArr) ; $x++) { 
					//find matching plan ID's
					if ($events[$i]["plan_ID"] == $WorkoutsArr[$x]["plan_ID"]) {
						$reps =  $WorkoutsArr[$x]["reps"] + $reps;
					}
				}
			}

			return $reps;
		}else{
			return $reps;
		};	
	}

	function getWeight($con,$sql,$WorkoutsArr){
		$result = mysqli_query($con,$sql);
		while ($row = $result->fetch_assoc()) {
			$events[] = $row;
		};

		$weight = 0;

		//check if either array is empty
		if(!empty($events) and !empty($WorkoutsArr)){
			//loop through events array
			for ($i=0; $i <count($events) ; $i++) {

				//loop through workouts array
				for ($x=0; $x <count($WorkoutsArr) ; $x++) { 
					//find matching plan ID's
					if ($events[$i]["plan_ID"] == $WorkoutsArr[$x]["plan_ID"]) {
						$weight =  $WorkoutsArr[$x]["weight"] + $weight;
					}
				}
			}
			return $weight;
		}else{
			return $weight;
		};	
	}

	function findFavCategory($catArr){
			
			//Find the highest value in the array
			//by using PHP's max function.
			$maxVal = max($catArr);

			//Use array_search to find the key that
			//the max value is associated with
			$maxKey = array_search($maxVal, $catArr);
			return $maxKey;
	};

	function getWorkoutTotal($sql,$con,$WorkoutsArr){
		$result = mysqli_query($con,$sql);
		while ($row = $result->fetch_assoc()) {
			$events[] = $row;
		};

		$total = 0;
		if(!empty($events) and !empty($WorkoutsArr)){
			for ($i=0; $i <count($events) ; $i++) {

				for ($x=0; $x <count($WorkoutsArr) ; $x++) { 
					if ($events[$i]["plan_ID"] == $WorkoutsArr[$x]["plan_ID"]) {
						$total++;
					}
				}
			}
			return $total;
		}else{
			return 0;
		};		
	}


	function getArr($sql,$con){
		$result = mysqli_query($con,$sql);
		while ($row = $result->fetch_assoc()) {
			$assocArr[] = $row;
		};

		if(empty($assocArr)){
			return 0;	
		}else{
			return $assocArr;
		};	
	}

	function getTotals($sql,$con){
		$result = mysqli_query($con,$sql);
		while ($row = $result->fetch_assoc()!== null) {
			$assocArr[] = $row;
		};

		if(empty($assocArr)){
			return 0;	
		}else{
			return count($assocArr) + 1;
		};	
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Profile Page</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<script src="jquery-1.js" type="text/javascript"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
	</head>
	<body class="loggedin">
		<div class="content">
			<div class="contentbox">
			<h2>Profile Page</h2>
				<select name="view" id="view">
				  <option value="All">All</option>
				  <option value="Month">Month</option>
				  <option value="Week">Week</option>
				</select>

				<div class = "container">
					<h3>Account Details:</h3>
						<table>
							<tr>
								<td>Username:</td>
								<td id ="sec"><?=$_SESSION['name']?></td>
							</tr> 
							<tr>
								<td>Email:</td>
								<td id ="sec"><?=$user_email?></td>
							</tr>
						</table>
				</div>

					<div class="chartcontainer">
						<canvas id="myChart"></canvas>
					</div>

				<div class = "container">
					<h3>Statistics:</h3>	
						<table>
							<tr>
								<td>Total Custom Plans:</td>
								<td id ="sec"><?=$plansTotal?></td>
							</tr>
							<tr>
								<td>Total Custom Categories:</td>
								<td id ="sec"><?=$catTotal?></td>
							</tr>
							<tr>
								<td>Total Custom Workouts:</td>
								<td id ="sec"><?=$customWorkoutTotal?></td>
							</tr>
							<tr>
								<td>Completed Plans:</td>
								<td id ="sec"><input type="text" class="textbox" id="compPlans" readonly></td>
							</tr>
							<tr>
								<td>Total Completed Workouts:</td>
								<td id ="sec"><input type="text" class="textbox" id="compWorkouts" readonly></td>
							</tr>
							<tr>
								<td>Total Weight:</td>
								<td id ="sec"><input type="text" class="textbox" id="weight" readonly></td>
							</tr>
							<tr>
								<td>Total Reps:</td>
								<td id ="sec"><input type="text" class="textbox" id="reps" readonly></td>
							</tr>
							<tr>
								<td>Favourite Category:</td>
								<td id ="sec"><input type="text" class="textbox" id="favCat" readonly></td>
							</tr>
							<tr>
								<td>Favourite Workout:</td>
								<td id ="sec"><input type="text" class="textbox" id="favWorkout" readonly></td>
							</tr>

						</table>
					</div>
				</div>
			</div>
		<script type="text/javascript">

		var data = Array();
		//Completed Plans
		var completedPlansTotal = <?php echo $completedPlansTotal ?>;
		var	totalPlansMonth = <?php echo $totalPlansMonth ?>;
		var	totalPlansWeek = <?php echo $totalPlansWeek ?>;	

		//Completed Workouts
		var workoutsTotal = <?php echo $workoutsTotal ?>;
		var workoutsMonthTotal = <?php echo $workoutsMonthTotal ?>;
		var workoutsWeekTotal = <?php echo $workoutsWeekTotal ?>;

		//reps
		var repsAll = <?php echo $repsAll ?>;
		var repsMonth = <?php echo $repsMonth ?>;
		var repsWeek = <?php echo $repsWeek ?>;

		//weight
		var weightAll = <?php echo $weightAll ?>;
		var weightMonth = <?php echo $weightMonth ?>;
		var weightWeek = <?php echo $weightWeek ?>;

		//favourite workout
		var favWorkoutAll = <?php echo json_encode($favWorkoutAll) ?>;
		var favWorkoutMonth = <?php echo json_encode($favWorkoutMonth) ?>;
		var favWorkoutWeek = <?php echo json_encode($favWorkoutWeek) ?>;

		//favourite category
		var favCatAll = <?php echo json_encode($favCatAll) ?>;
		var favCatMonth = <?php echo json_encode($favCatMonth) ?>;
		var favCatWeek = <?php echo json_encode($favCatWeek) ?>;

		//favourite category array
		var catArrAll = <?php echo json_encode($catArrAll) ?>;
		var catArrMonth = <?php echo json_encode($catArrMonth) ?>;
		var catArrWeek = <?php echo json_encode($catArrWeek) ?>;


		//Arrays
		var compAllWorkoutsArr = <?php echo json_encode($compAllWorkoutsArr) ?>;
		var compMonthWorkoutsArr = <?php echo json_encode($compMonthWorkoutsArr) ?>;
		var compWeekWorkoutsArr = <?php echo json_encode($compWeekWorkoutsArr) ?>;
		var compAllPlansArr = <?php echo json_encode($compAllPlansArr) ?>;
		var compMonthPlansArr = <?php echo json_encode($compAllPlansArr) ?>;
		var compWeekPlansArr = <?php echo json_encode($compWeekPlansArr) ?>;

		$( document ).ready(function() {
		    data = selectChange();
			chart = new Chart($('#myChart'), {
			    type: 'doughnut',
			    data: {
			      labels: Object.keys(data),
			      datasets: [
			        {
			          backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
			          data: Object.values(data)
			        }
			      ]
			    },
			    options: {
			      maintainAspectRatio: false,
			      responsive: true,
			      title: {
			        display: true,
			        text: 'Category Breakdown'
			      },
			      layout: {
		            padding: {
		                left: 0,
		                right: 0,
		                top: 0,
		                bottom: 0
		            }
	        	  }
			    }
			});
		});
		//display all/month/week stats
		$( "#view" ).change(function() {
			data = selectChange();
			chart.destroy();
			chart = new Chart($('#myChart'), {
			    type: 'doughnut',
			    data: {
			      labels: Object.keys(data),
			      datasets: [
			        {
			          backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
			          data: Object.values(data)
			        }
			      ]
			    },
			    options: {
			      maintainAspectRatio: false,
			      responsive: true,
			      title: {
			        display: true,
			        text: 'Category Breakdown'
			      },
			      layout: {
		            padding: {
		                left: 0,
		                right: 0,
		                top: 0,
		                bottom: 0
		            }
	        	  }
			    }
			});
		});
		
		// Any of the following formats may be used




	

		function selectChange(){

			if ($('#view').find(":selected").text() == "All"){

				$('#compPlans').val(completedPlansTotal);
				$('#compWorkouts').val(workoutsTotal);
				$('#favWorkout').val(favWorkoutAll);
				$('#favCat').val(favCatAll);
				$('#weight').val(weightAll + "kg");
				$('#reps').val(repsAll);
				return catArrAll;

			}else if ($('#view').find(":selected").text() == "Month") {

				$('#compPlans').val(totalPlansMonth);
				$('#compWorkouts').val(workoutsMonthTotal);
				$('#favWorkout').val(favWorkoutMonth);
				$('#favCat').val(favCatMonth);
				$('#weight').val(weightMonth + "kg");
				$('#reps').val(repsMonth);

				return catArrMonth;

			}else if ($('#view').find(":selected").text() == "Week") {

				$('#compPlans').val(totalPlansWeek);
				$('#compWorkouts').val(workoutsWeekTotal);
				$('#favWorkout').val(favWorkoutWeek);
				$('#favCat').val(favCatWeek);
				$('#weight').val(weightWeek + "kg");
				$('#reps').val(repsWeek);


				return catArrWeek;
			}
		}


		</script>
	</body>
</html>