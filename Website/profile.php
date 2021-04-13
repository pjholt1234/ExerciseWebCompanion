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
	include ('statfunc.php');
	
	//Get Array of workouts from db
	$sql = "SELECT * FROM workouts WHERE user_made = '0' OR user_ID = '$userID'";
	$result = mysqli_query($con,$sql);

	//Fetch into associative array
	while ($row = $result->fetch_assoc()){
		$allWorkouts[]=$row;
	};

	//check if user has goals if not create instance and set to 1
	$sql = "SELECT user_ID FROM goals WHERE user_ID = '$userID'";
	$result = mysqli_query($con,$sql);
	if (mysqli_num_rows($result) == 0) {
		$sql = "INSERT INTO goals (user_ID, monthly_goal, weekly_goal) values ('$userID',1,1);";
		//Send Query
		mysqli_query($con,$sql);
	};

	$sql = "SELECT monthly_goal, weekly_goal FROM goals WHERE user_ID = '$userID'";
	$result = mysqli_query($con,$sql);
	//Fetch into associative array
	while ($row = $result->fetch_assoc()) {
		$goalsArr[] = $row;
	};

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

	//get number of workouts per calendar week
	$sql = "SELECT
    WEEKOFYEAR(end_event) AS weekno, 
    COUNT(1) AS events,
    SUBDATE(end_event, INTERVAL WEEKDAY(end_event) DAY) AS date_of_week
	FROM events WHERE user_ID = '$userID'
	GROUP BY WEEKOFYEAR(end_event);";
    $result = mysqli_query($con,$sql);

    //Fetch into associative array
	while ($row = $result->fetch_assoc()) {
		$arr[] = $row;
	};

	if (!empty($arr)) {
		$workoutsPerWeek = array();
		for ($x=0; $x <count($arr) ; $x++) {
			$dateOfWeek = explode(" ", $arr[$x]["date_of_week"]);
			$workoutsPerWeek += array($dateOfWeek[0] => $arr[$x]["events"]);	
		};
	}else{
		$workoutsPerWeek = array('none' => 0);
	}
	


	//get number of workouts per calendar month
	$sql = "SELECT COUNT(*) AS plans, MONTHNAME(end_event) AS month FROM events WHERE user_ID = '$userID' GROUP BY MONTH(end_event)";
    $result = mysqli_query($con,$sql);

    //Fetch into associative array
	while ($row = $result->fetch_assoc()) {
		$arr2[] = $row;
	};
	if (!empty($arr2)) {
		$workoutsPerMonth = array();
		for ($x=0; $x <count($arr2) ; $x++) {
			$workoutsPerMonth += array($arr2[$x]["month"] => $arr2[$x]["plans"]);	
		};
	}else{
		$workoutsPerMonth = array('none' => 0);
	}
	//get weight array
	$sql = "SELECT weight, entry_date FROM weight WHERE user_ID = '$userID'";
	$result = mysqli_query($con,$sql);

	//Fetch into associative array
	while ($row = $result->fetch_assoc()) {
		$tempWeightArr[] = $row;
	};

	if (empty($tempWeightArr)) {
		$n = array('weight' => 0, 'entry_date' => 0);
		$weightArr = array($n);

	}else{
		$weightArr = $tempWeightArr;
	};

	

	//*--This is where all time dependant stats are generated--*
	//define todays date
	$today = date("Y/m/d");

	//define this month & year
	$month = date("m");
	$year = date("Y");

	//All Time stats
	$sql="SELECT * FROM events WHERE end_event < '$today' AND user_ID = '$userID'";
	$result = mysqli_query($con,$sql);
		while ($row = $result->fetch_assoc()) {
			$events[] = $row;
		};
	$completedPlansTotal = getTotals($sql,$con);
	$compAllPlansArr = getArr($sql,$con);
	$workoutsTotal = getWorkoutTotal($sql,$con,$WorkoutsArr);
	$compAllWorkoutsArr = getArr($sql,$con);
	$favWorkoutAll = findFavWorkout($con,$sql,$WorkoutsArr);
	$catArrAll = getCategoryArr($con,$sql,$WorkoutsArr);
	$favCatAll = findFavCategory($catArrAll);
	$repsAll = getReps($con,$sql,$WorkoutsArr);
	$weightAll = getWeight($con,$sql,$WorkoutsArr);
	$workoutStatsAll= workoutStats($con,$sql,$WorkoutsArr,$allWorkouts);

	//Month stats
	$sql="SELECT * FROM events WHERE MONTH(end_event) = '$month' AND YEAR(end_event) = '$year' AND end_event < '$today' AND user_ID = '$userID'";
	$totalPlansMonth = getTotals($sql,$con);
	$compMonthPlansArr = getArr($sql,$con);
	$workoutsMonthTotal = getWorkoutTotal($sql,$con,$WorkoutsArr);
	$compMonthWorkoutsArr = getArr($sql,$con);
	$favWorkoutMonth = findFavWorkout($con,$sql,$WorkoutsArr);
	$catArrMonth = getCategoryArr($con,$sql,$WorkoutsArr);
	$favCatMonth = findFavCategory($catArrMonth);
	$repsMonth = getReps($con,$sql,$WorkoutsArr);
	$weightMonth = getWeight($con,$sql,$WorkoutsArr);
	$workoutStatsMonth = workoutStats($con,$sql,$WorkoutsArr,$allWorkouts);

	//Week stats
	$sql="SELECT * FROM events WHERE WEEKOFYEAR(end_event) = WEEKOFYEAR(NOW()) AND user_ID = '$userID'";
	$totalPlansWeek = getTotals($sql,$con);
	$compWeekPlansArr = getArr($sql,$con);
	$workoutsWeekTotal = getWorkoutTotal($sql,$con,$WorkoutsArr);
	$compWeekWorkoutsArr = getArr($sql,$con);
	$favWorkoutWeek = findFavWorkout($con,$sql,$WorkoutsArr);
	$catArrWeek = getCategoryArr($con,$sql,$WorkoutsArr);
	$favCatWeek = findFavCategory($catArrWeek);
	$repsWeek = getReps($con,$sql,$WorkoutsArr);
	$weightWeek = getWeight($con,$sql,$WorkoutsArr);
	$workoutStatsWeek = workoutStats($con,$sql,$WorkoutsArr,$allWorkouts);

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
				<form id = "update" name = "update" method="post" action="updateGoal.php">	
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
					<input type="hidden" class="textbox" name = "goalType" id="goalType" value = "">
				</div>
				<div class = "container">
					<h3>Workout Breakdown:</h3>
					<select name="workoutSelect" id="workoutSelect"></select>	
						<table>
							<tr>
								<td id ="maxUnitText">placeholder</td>
								<td id ="maxUnit">placeholder</td>
							</tr>
							<tr>
								<td id ="maxWeightText">placeholder</td>
								<td id ="maxWeight">placeholder</td>
							</tr>
							<tr>
								<td id ="totalUnitText">placeholder</td>
								<td id ="totalUnit">placeholder</td>
							</tr>
							<tr>
								<td id ="totalWeightText">placeholder</td>
								<td id ="totalWeight">placeholder</td>
							</tr>
						</table>
				</div>
			</div>
				<div class = "container2">
					<div class="chartcontainer2">
						<canvas id="myBarChart"></canvas>
						<div class = "goalcontainer">
							<div class = desc>
								<p class = "desc">Here You Can Set Your Monthly / Weekly Workout Goals. Select your time frame above then type in the input box and click "Set"</p>
							</div>
							<table>
								<tr>
									<td id ="setGoal">Monthly Workout Goal:</td>
									<td id ="sec"><input type="text" class="goaltextbox" id="monthGoal" name = "monthGoal"></td>
									<td><input class='set' type='button' value='Set' id='Set'></td>
								</tr>
								<tr>
									<td id ="succesfulGoals">Monthly Goals Met:</td>
									<td id ="sec"><input type="text" class="textbox" id="metMonthGoals" readonly></td>
								</tr>
								<tr>
									<td id ="setGoal">Week Workout Goal:</td>
									<td id ="sec"><input type="text" class="goaltextbox" id="weekGoal" name = "weekGoal"></td>
									<td><input class='set' type='button' value='Set' id='Set'></td>
								</tr>
								<tr>
									<td id ="succesfulGoals">Week Goals Met:</td>
									<td id ="sec"><input type="text" class="textbox" id="metWeekGoals" readonly></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				</form>
				<div class = "container3">
					<div class="chartcontainer2">
						<canvas id="myLineChart"></canvas>
						<div class = "goalcontainer">
							<form id = "addWeight" name = "addWeight" method="post" action="addWeight.php">
							<div class = desc>
								<p class = "desc">Here You can set your current weight & track your progress</p>
							</div>
							<table>
								<tr>
									<td id ="setWeight">Set Current Weight:</td>
									<td id ="sec"><input type="text" class="goaltextbox" id="weight" name = "weight"></td>
									<td><input class='setWeight' type='button' value='Set' id='Set'></td>
								</tr>
							</table>
							</form>
						</div>
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

		//workoutstatsArrays
		var workoutStatsAll = <?php echo json_encode($workoutStatsAll) ?>;
		var workoutStatsMonth = <?php echo json_encode($workoutStatsMonth) ?>;
		var workoutStatsWeek = <?php echo json_encode($workoutStatsWeek) ?>;

		//Arrays
		var compAllWorkoutsArr = <?php echo json_encode($compAllWorkoutsArr) ?>;
		var compMonthWorkoutsArr = <?php echo json_encode($compMonthWorkoutsArr) ?>;
		var compWeekWorkoutsArr = <?php echo json_encode($compWeekWorkoutsArr) ?>;
		var compAllPlansArr = <?php echo json_encode($compAllPlansArr) ?>;
		var compMonthPlansArr = <?php echo json_encode($compAllPlansArr) ?>;
		var compWeekPlansArr = <?php echo json_encode($compWeekPlansArr) ?>;
		var workoutsPerWeek = <?php echo json_encode($workoutsPerWeek) ?>;
		var workoutsPerMonth = <?php echo json_encode($workoutsPerMonth) ?>;
		var goalsArr = <?php echo json_encode($goalsArr) ?>;
		var weightArr = <?php echo json_encode($weightArr) ?>;
		var workoutArr = <?php echo json_encode($allWorkouts) ?>;

		var backgrounds = ["#25CCF7","#FD7272","#54a0ff","#00d2d3",
									    "#1abc9c","#2ecc71","#3498db","#9b59b6","#34495e",
									    "#16a085","#27ae60","#2980b9","#8e44ad","#2c3e50",
									    "#f1c40f","#e67e22","#e74c3c","#ecf0f1","#95a5a6",
									    "#f39c12","#d35400","#c0392b","#bdc3c7","#7f8c8d",
									    "#55efc4","#81ecec","#74b9ff","#a29bfe","#dfe6e9",
									    "#00b894","#00cec9","#0984e3","#6c5ce7","#ffeaa7",
									    "#fab1a0","#ff7675","#fd79a8","#fdcb6e","#e17055",
									    "#d63031","#feca57","#5f27cd","#54a0ff","#01a3a4"];
		//calculate succesful goals
		var succesfulWeekGoal = 0;
		var succesfulMonthGoal = 0;
		for (var key in workoutsPerWeek) {
		    if (workoutsPerWeek.hasOwnProperty(key)) {
		        if (workoutsPerWeek[key] >= goalsArr[0]["weekly_goal"]) {
					succesfulWeekGoal++;
				};
		    }
		}
		$('#weekGoal').val(goalsArr[0]["weekly_goal"]);
		$('#metWeekGoals').val(succesfulWeekGoal);

		for (var key in workoutsPerMonth) {
		    if (workoutsPerMonth.hasOwnProperty(key)) {
		        if (workoutsPerMonth[key] >= goalsArr[0]["monthly_goal"]) {
					succesfulMonthGoal++;
				};
		    }
		}
		$('#monthGoal').val(goalsArr[0]["monthly_goal"]);
		$('#metMonthGoals').val(succesfulMonthGoal);

		$(".set").click(function (){
			$("#update").submit();    	
		});
		$(".setWeight").click(function (){
			$("#addWeight").submit();    	
		});

		


		var labels = weightArr.map(function(e) {
		   return e.entry_date;
		});
		var data = weightArr.map(function(e) {
		   return e.weight;
		});

		$( window ).on( "load", function() {
        	workoutChange();
    	});

		$( document ).ready(function() {
			updateWorkoutSelect();	
			var selection = selectChange();
			if (selection == "All") {

				title = "Week";
				doughnutData = catArrAll;

			}else if(selection == "Month"){

				title = "Month";
				doughnutData = catArrMonth;

			}else if(selection == "Week"){

				title = "Week";
				doughnutData = catArrWeek;

			}

			doughnutChart = new Chart($('#myChart'), {
			    type: 'doughnut',
			    data: {
			      labels: Object.keys(doughnutData),
			      datasets: [
			        {
			          backgroundColor: backgrounds,
			          data: Object.values(doughnutData)
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

			barchart = new Chart($('#myBarChart'), {
			    type: 'bar',
			    data: {
			      labels: Object.keys(workoutsPerWeek),
			      datasets: [
			        {
			          backgroundColor: backgrounds,
			          data: Object.values(workoutsPerWeek)
			        }
			      ]
			    },
			    options: {
			      legend:{
			      	display: false
			      },
			      maintainAspectRatio: false,
			      responsive: true,
			      title: {
			        display: true,
			        text: 'Workouts Per ' + title
			      },
			      layout: {
		            padding: {
		                left: 0,
		                right: 0,
		                top: 0,
		                bottom: 0
		            }
	        	  },
	        	  scales: {
		          	yAxes: [{
		          		ticks: {
		          			beginAtZero: true,
		          			stepSize: 1
		          		}
		          	}]  
		          }
			    }
			});
			if (!(data == 0)) {
				linechart = new Chart($('#myLineChart'), {
			    type: 'line',
			    data: {
				      labels: labels,
				      datasets: [{
				         label: 'Graph Line',
				         data: data,
				         backgroundColor: "#25CCF7",
				         borderColor: "#FD7272",
				         fill: false
				      }]
				},
				options: {
			      legend:{
			      	display: false
			      },
			      maintainAspectRatio: false,
			      responsive: true,
			      title: {
			        display: true,
			        text: 'Your Weight'
			      },
			      layout: {
		            padding: {
		                left: 0,
		                right: 0,
		                top: 0,
		                bottom: 0
		            }
	        	  },
	        	  scales: {
		          	yAxes: [{
		          		ticks: {
		          			beginAtZero: true,
		          			stepSize: 5
		          		}
		          	}]  
		          }
			    }
			});
			}
			

		
		});
		
		$('#workoutSelect').change(function() {
			workoutChange();	
		});
		$('#view').change(function() {
			workoutChange();
		});

		//display all/month/week stats
		$( "#view" ).change(function() {
			var selection = selectChange();
			if (selection == "All") {

				title = "All";
				doughnutData = catArrAll;
				

			}else if(selection == "Month"){

				title = "Month";
				doughnutData = catArrMonth;


			}else if(selection == "Week"){

				title = "Week";
				doughnutData = catArrWeek;

			}

			doughnutChart.destroy();
			doughnutChart = new Chart($('#myChart'), {
			    type: 'doughnut',
			    data: {
			      labels: Object.keys(doughnutData),
			      datasets: [
			        {
			          backgroundColor: backgrounds,
			          data: Object.values(doughnutData)
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

		function workoutChange(){

			var selectedWorkout = $('#workoutSelect').find(":selected").val();
			var selectedTime = $('#view').find(":selected").text();

			if (selectedTime  == "All"){
				
				for(i=0; i<workoutStatsAll.length;i++){

					if (workoutStatsAll[i]["workout_ID"] == selectedWorkout) {

						unit = workoutStatsAll[i]["unit"];
						$('#maxUnitText').html('Max ' + unit + ': ');
						$('#maxUnit').html(workoutStatsAll[i]["maxUnit"]);
						$('#maxWeightText').html('Max weight: ');
						$('#maxWeight').html(workoutStatsAll[i]["maxWeight"]+ "kg");
						$('#totalUnitText').html('Total ' + unit + ': ');
						$('#totalUnit').html(workoutStatsAll[i]["totalUnit"]);
						$('#totalWeightText').html('Total weight: ');
						$('#totalWeight').html(workoutStatsAll[i]["totalWeight"]+ "kg");

					}
				}

			}else if(selectedTime  == "Month"){

				for(i=0; i<workoutStatsMonth.length;i++){

					if (workoutStatsMonth[i]["workout_ID"] == selectedWorkout) {

						unit = workoutStatsMonth[i]["unit"];
						$('#maxUnitText').html('Max ' + unit + ': ');
						$('#maxUnit').html(workoutStatsMonth[i]["maxUnit"]);
						$('#maxWeightText').html('Max weight: ');
						$('#maxWeight').html(workoutStatsMonth[i]["maxWeight"]+ "kg");
						$('#totalUnitText').html('Total ' + unit + ': ');
						$('#totalUnit').html(workoutStatsMonth[i]["totalUnit"]);
						$('#totalWeightText').html('Total weight: ');
						$('#totalWeight').html(workoutStatsMonth[i]["totalWeight"]+ "kg");

					}
				}

			}else if (selectedTime  == "Week"){

				for(i=0; i<workoutStatsWeek.length;i++){

					if (workoutStatsWeek[i]["workout_ID"] == selectedWorkout) {

						unit = workoutStatsWeek[i]["unit"];
						$('#maxUnitText').html('Max ' + unit + ': ');
						$('#maxUnit').html(workoutStatsWeek[i]["maxUnit"]);
						$('#maxWeightText').html('Max weight: ');
						$('#maxWeight').html(workoutStatsWeek[i]["maxWeight"]+ "kg");
						$('#totalUnitText').html('Total ' + unit + ': ');
						$('#totalUnit').html(workoutStatsWeek[i]["totalUnit"]);
						$('#totalWeightText').html('Total weight: ');
						$('#totalWeight').html(workoutStatsWeek[i]["totalWeight"] + "kg");

					}
				}

			}
		

		}

		function updateWorkoutSelect(){
			//empty workout select
			$('#workoutSelect').empty();

			//loop through workout array and find all workouts under the chosen catagory
			for(i=0; i<workoutArr.length;i++){

				//Create new dom object
				var o = new Option(workoutArr[i].workout_name, workoutArr[i].workout_ID);

				//jquerify the DOM object 'o' so we can use the html method
				$(o).html(workoutArr[i].workout_name);
				$("#workoutSelect").append(o);
					
			};
		}


		function selectChange(){

			if ($('#view').find(":selected").text() == "All"){

				$('#compPlans').val(completedPlansTotal);
				$('#compWorkouts').val(workoutsTotal);
				$('#favWorkout').val(favWorkoutAll);
				$('#favCat').val(favCatAll);
				$('#weight').val(weightAll + "kg");
				$('#reps').val(repsAll);
				return "All";
				

			}else if ($('#view').find(":selected").text() == "Month") {

				$('#compPlans').val(totalPlansMonth);
				$('#compWorkouts').val(workoutsMonthTotal);
				$('#favWorkout').val(favWorkoutMonth);
				$('#favCat').val(favCatMonth);
				$('#weight').val(weightMonth + "kg");
				$('#reps').val(repsMonth);
				return "Month";

			}else if ($('#view').find(":selected").text() == "Week") {

				$('#compPlans').val(totalPlansWeek);
				$('#compWorkouts').val(workoutsWeekTotal);
				$('#favWorkout').val(favWorkoutWeek);
				$('#favCat').val(favCatWeek);
				$('#weight').val(weightWeek + "kg");
				$('#reps').val(repsWeek);
				return "Week";
			}
		}

		</script>
	</body>
</html>