<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Plan A Workout</title>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link href="planworkout.css" rel="stylesheet" type="text/css">
	<script src="jquery-1.js" type="text/javascript"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js"></script>

	<?php
	session_start();
	$userID = $_SESSION['id'];

	// Connect to database
	include ('dbcon.php');

	//Get Array of catagories from db
	$sql= "SELECT catagory_ID, catagory_name, catagory_desc FROM categories WHERE user_made = '0' OR user_ID = '$userID'";
	$result = mysqli_query($con,$sql);

	while ($row = $result->fetch_assoc()) {
		$catagoryArr[] = $row;
	}

	//Get Array of workouts from db
	$sql = "SELECT * FROM workouts WHERE user_made = '0' OR user_ID = '$userID'";
	$result = mysqli_query($con,$sql);

	//Fetch into associative array
	while ( $row = $result->fetch_assoc()){
		$workoutArr[]=$row;
	};

	$sql = "SELECT * FROM plans_workouts WHERE user_ID = '$userID'";
	$result = mysqli_query($con,$sql);


	while ( $row = $result->fetch_assoc()){
		$userWorkoutsArr[]=$row;
	};

	//check if userWorkoutsArr is empty to prevent error when passing to javascript
	if (empty($userWorkoutsArr)) {
		$userWorkoutsArr = array("empty" => "empty");  
	}


	$sql = "SELECT * FROM plans WHERE user_ID = '$userID'";
	$result = mysqli_query($con,$sql);

	while ( $row = $result->fetch_assoc()){
		$userPlansArr[]=$row;
	};

	//check if userPlansArr is empty to prevent error when passing to javascript
	if (empty($userPlansArr)) {
		$userPlansArr = array("empty" => "empty");   
	}
	?>

	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js"></script>
	<script>

		$( function() {
			$( "#sortable" ).sortable();
			$( "#sortable" ).disableSelection();
		});

	</script>


</head>
<body>
	<form id= "sub" action="submit.php" method = "POST">

		<input type="hidden" id="plans" class ="plans" name="plans" value="">
		<div id ="main" class = "contentbox">

			<div id="plans" class = "contentbox">
				<label id ="select" class="select">Your Workout Plans</label><br>
				<div id="accordion"></div>
			</div>

			<div id="adder" class="buttonBox">
				<label id ="select" class="select">Select A Category And Add A Workout</label><br>

				<select class='select-css' name="workoutCat" id ="workoutCat">
					<?php foreach ($catagoryArr as $row): ?>
						<option value="<?= $row['catagory_ID'] ?>"><?=$row["catagory_name"]?></option>
					<?php endforeach ?>
				</select>
				<select class='select-css' name="workout" id ="workout"></select>

				<input type='text' class = "inputbox" id="timereps" placeholder ="" name="text"size="6">
				<input type="text" class = "inputbox" id="weight" placeholder ="Weight - KG " name="text"size="6">
				<input type='text' class ="planName" id="planName" placeholder ="Plan Name" name="planName"><br>

				<input class='button' type='button' value='Add' id='Add'>
				<input class='button' type='submit' value='Save'id='Save' name='Save'>

			</div>

			<div id="workoutPlan" class="workoutPlan">
				<ul class ="workouts" id="sortable"></ul>
			</div>
		</div>
		<input type="hidden" name="str" id = "str" class = "str">
		<input type="hidden" name="opt" id = "opt" class = "opt">
	</form>

	<div style="display: none;" class="pop-outer" id = "createCategory">
      <div class="pop-inner">
        <button class="close">X</button>
        	<form id= "newCategory" action="createNewCategory.php" method = "POST">
		        <h2 id="newCatH">Create New Category & New Workout</h2>
		        <p id="newCatP">From here you can create a new category with your desired exercise</p>
		        <input type="text" class = "newinputbox" id="newCat" placeholder ="New Category Name" name="newCat"><br>
		        <textarea class = "newinputboxbig" id="newCatDesc" placeholder ="New Category Description" name="newCatDesc"></textarea><br>

		        <input type="text" class = "newinputbox" id="newWorkout" placeholder ="New Workout Name" name="newWorkout"><br>
		        <textarea class = "newinputboxbig" id="newWorkoutDesc" placeholder ="New Workout Description" name="newWorkoutDesc"></textarea><br>

		        New Workout Measurement: 
		        <select class='newMeasurement' name="newMeasurement" id ="newMeasurement">
		        	<option value="Reps">Reps</option>
		        	<option value="Duration">Duration</option>
		        </select>

		        <input class='buttonSave' type='submit' value='Save'id='Save' name='Save'>
		      </form>
      </div>
   </div>

   <div style="display: none;" class="pop-outer" id = "createWorkout">
      <div class="pop-inner">
        <button class="close">X</button>
        	<form id= "newCategory" action="createNewWorkout.php" method = "POST">
		        <h2 id="newWorkoutH"></h2>
		        <p id="newWorkoutP"></p>
		        <input type="hidden" id="cat" class ="cat" name="cat" value="">

		        <input type="text" class = "newinputbox" id="newWorkout" placeholder ="New Workout Name" name="newWorkout"><br>
		        <textarea class = "newinputboxbig" id="newWorkoutDesc" placeholder ="New Workout Description" name="newWorkoutDesc"></textarea><br>

		        New Workout Measurement: 
		        <select class='newMeasurement' name="newMeasurement" id ="newMeasurement">
		        	<option value="Reps">Reps</option>
		        	<option value="Duration">Duration</option>
		        </select>

		        <input class='buttonSave' type='submit' value='Save'id='Save' name='Save'>
		      </form>
      </div>
   </div>

<script>


	

	//Intialise variables 
	var catagory_ID = $("select[name='workoutCat']").val();
	var catagory_name = "";
	var buttonPressed = "";
	var count = 0;
	var buttonPressed = "";

	// pass PHP variable declared above to JavaScript variable
	var workoutArr = <?php echo json_encode($workoutArr) ?>;  
	var catagoryArr = <?php echo json_encode($catagoryArr) ?>;
	var userWorkoutsArr = <?php echo json_encode($userWorkoutsArr) ?>; 
	var userPlansArr = <?php echo json_encode($userPlansArr) ?>;  

	$( function() {
			$( "#accordion" ).accordion();
	});

	//on load make sure that the drop downs have the contents loaded
	$(window).on('load', function () {
		catagoryChange(); 
	});

	//detect save
	$("#Save").click(function() {
		savePlan();
	});
	//detect change in workout catagory.
	$("#workoutCat").change(function() {
		catagoryChange();
	});

	//function to find if workout is reps or time.
	$( "#workout" ).change(function() {
		workoutChange();
	});

	//Detect Delete btn click
	$(document).on('click','.deletebtn', function(e){

		//Get ID
		selectedID = $(e.target).attr('id');
		idSpit = selectedID.split("_");

			//loop Through Plans array
			for (var i = userPlansArr.length - 1; i >= 0; i--) {

				//select plan play by ID
				if (userPlansArr[i]["plan_ID"] == idSpit[1]) {
					confirmPlan = userPlansArr[i]["plan_name"];  
				};
			};

		//Delete Comfirmation
		ans = confirm("Are you sure you want to delete '"+confirmPlan+"' ?");
		if (ans == true) {
			//set option to delete
			$("#opt").empty();
			$("#opt").val("del");

			//Append text box with ID
			$("#str").empty();
			$("#str").val(idSpit[1]);
			$("#sub").submit();
		};
	});

	//Detect Copy button
	$(document).on('click','.copybutton', function(e){

		//get table ID
		selectedID = $(e.target).attr('id');
		idSpit = selectedID.split("_");
		tableID = "#table_"+idSpit[1];
		prevID = 0;

		//find largest ID
		for (var i = 0; i < totalListItems(); i++){
		//Largest ID
			if (getLiID(i+1) > prevID) {
				prevID = getLiID(i+1);
			}
		};

		id = 1 + parseInt(prevID);

		//get unit of measurement from table
		unit = $(tableID+" tr:first th:eq(3)").text().replace(":","");

		//create duplicate list Item
		createListElement(id,$(tableID+" tr:first th:eq(1)").text(),$(tableID+" tr:first th:eq(2)").text(),unit, $(tableID+" tr:first th:eq(4)").text(), $(tableID+" tr:first th:eq(6)").text());
	});

	//Detect edit plan btn
	$(document).on('click','.editPlanbtn',function(e){
		
		//make sure list is empty
		$("#sortable").empty();

		//get plan ID
		id = $(e.target).attr('id');
		var idSpit = id.split("_");
		planID = idSpit[1];
		editPlanName = " ";
		i = 0;

		//find plan with ID
		for (var i = userPlansArr.length - 1; i >= 0; i--) {

			if (userPlansArr[i]["plan_ID"] == planID) {
				editPlanName = userPlansArr[i]["plan_name"];  
			};

		};

		//assign plan to select plan name
		$("#planName").val(editPlanName);

		// loop through workouts
		for (z=0; z<userWorkoutsArr.length;z++) {
			if (userWorkoutsArr[z]["plan_ID"] == planID) {

				if (userWorkoutsArr[z]["unit"] == "Duration") {
						amount = userWorkoutsArr[z]["duration"];
					}else{
						amount = userWorkoutsArr[z]["reps"];
				};

				//fill list with plan details
				createListElement(z,userWorkoutsArr[z]["catagory_name"],userWorkoutsArr[z]["workout_name"],userWorkoutsArr[z]["unit"],amount,userWorkoutsArr[z]["weight"]);    
			};
		};
	});

		//custom category
		$( "#workoutCat" ).change(function() {
			//get select option
	    $( "select option:selected" ).each(function() {
	    	//open popup
	      if ($( this ).text() == "Custom") {
					$("#createCategory").fadeIn("slow");     
	      };
	    });
		});

		//close popup
  	$(".close").click(function (){
    	$("#createCategory").fadeOut("slow");
  	});
		

		//custom workout
		$( "#workout" ).change(function() {
	    $( "select option:selected" ).each(function() {
	      if ($( this ).text() == "Custom") {

	      	//get selected category
	      	selectedCat = $( "#workoutCat option:selected" ).text();

	      	//find category description
	      	for (var i = catagoryArr.length - 1; i >= 0; i--) {
	      		
	      		if (catagoryArr[i]["catagory_name"] == selectedCat) {
	      			catDesc = catagoryArr[i]["catagory_desc"];
	      		};
	      	};

	      	//append
	      	$('#newWorkoutH').empty();
	      	$('#newWorkoutP').empty();
	      	$('#cat').empty();
	      	$('#newWorkoutH').append("Create New Workout for: " + selectedCat);
	      	$('#newWorkoutP').append("Selected Category Description: " + catDesc);
	      	$('#cat').val(selectedCat);

	      	//fade in
					$("#createWorkout").fadeIn("slow");     
	      };
	    });
		});

  	$(".close").click(function (){
    	$("#createWorkout").fadeOut("slow");
  	});

	updateAccordion();

	function createListElement(count,catName,workoutName,measurement,amount,weight){

			var temptableID = "table_"+count;
			var tempdelID = "del_"+count;
			var templiID = "li_"+count;
			var tempCopyID = "copy_"+count;

			//Concatenate to form html, Contains:
			//All times are wrapped with a table
			//The span tag for an arrow
			//Catagory Name
			//Workout Name
			//Measurement of that workout (time or reps)
			//Value of time or reps
			//The weight
			//Delete button
			var str = "<table id ='"+temptableID+"'><tr><th><span class='ui-icon ui-icon-arrowthick-2-n-s'></span></th><th>"+catName+" </th><th>"+workoutName+"</th> <th>"+measurement+" : </th><th>"+amount+"</th> <th>Weight : </th><th>"+weight+"</th> <th>Kg</th><input class='delbutton' type='button' value='Del' id='"+tempdelID+"'/><input class='copybutton' type='button' value='Copy' id='"+tempCopyID+"'/></tr></table>";

			//Create a list object
			var $li = $("<li id='"+templiID+"' class='workouts'/>");



			//append list object to html
			$("#sortable").append($li);

			//append the table to the list
			$li.append(str);

			//refresh the table
			$("#sortable").sortable('refresh');  
	};
	//update the workout too
	function workoutChange (){
		for(j=0; j<workoutArr.length;j++){

			if (workoutArr[j].workout_name == getWorkoutName()) {
				if (workoutArr[j].repstime == 0) {
					$("#timereps").attr("placeholder","Reps");
				} else {
					$("#timereps").attr("placeholder","Duration");
				};
			};  
		};
	};

	function updateAccordion(){

		//IF accordion is empty assign text
		if (userWorkoutsArr['empty'] == "empty"||userPlansArr['empty'] == "empty") {

			var newElement = "<h2><a ref='#'>No Workouts</a></h2><div>Add A Workout and it will appear here!</div>";
			$("#accordion").append(newElement);

		}else{

			//loop through plans array
			for (var i = userPlansArr.length - 1; i >= 0; i--) {

				//assign variables
				var plan_name = userPlansArr[i]["plan_name"];
				var plan_ID = userPlansArr[i]["plan_ID"];
				var string ="";
				var count = 1;

				//create string to apply to accordion
				string += "<ul id = 'userPlans'>";
				string += "<li><b>Last Updated: </b>" + userPlansArr[i]["last_used"] + "</li><br>";

				//loop through workout array
				for (z=0; z<userWorkoutsArr.length;z++) {

					//if planID is = selected plan, add to string to apply to accordion
					if (userWorkoutsArr[z]["plan_ID"] == plan_ID) {

						//add individual workout list items
						string += "<li> <b>Exercise </b>#";
						string += (count).toString();
						string += "<br><b>Catagory:</b> ";
						string += userWorkoutsArr[z]["catagory_name"];
						string += "<br><b>Workout:</b> ";
						string += userWorkoutsArr[z]["workout_name"];
						string += "<br><b>";
						string += userWorkoutsArr[z]["unit"];
						string += ":</b> ";

						//detect workout unit
						if (userWorkoutsArr[z]["unit"] == "Duration") {
							string += userWorkoutsArr[z]["duration"];
						}else{
							string += userWorkoutsArr[z]["reps"];
						};

						string += " <br><b>Weight:</b> ";
						string += userWorkoutsArr[z]["weight"];
						string += " KG</li><br>";
						count ++;

					};

				};

				// close off list
				string += "</ul>";

				//add h tags(title) and buttons
				var newElement = "<h2><a ref='#'>"+ plan_name +"</a><input class='editPlanbtn' type='button' value='Edit' id='edit_"+userPlansArr[i]["plan_ID"]+"'>"+"<input class='deletebtn' type='submit' value='Del' name = 'del' id='delete_"+userPlansArr[i]["plan_ID"]+"'></h2><div id='accordionContent'>"+ string +"</div>";

				//accordion
				$("#accordion").append(newElement);

			};
		};
	};

	//update the catagory and therefore the workout too
	function catagoryChange(){      
		//empty workout select
		$('#workout').empty();
		//loop through workout array and find all workouts under the chosen catagory
		for(i=0; i<workoutArr.length;i++){

			if (workoutArr[i].catagory_ID == getCatagoryID()) {

				//Create new dom object
				var o = new Option(workoutArr[i].workout_name, i);

				//jquerify the DOM object 'o' so we can use the html method
				$(o).html(workoutArr[i].workout_name);
				$("#workout").append(o);
			};

			
		};
		var o = new Option("Custom", i);

		//jquerify the DOM object 'o' so we can use the html method
		$(o).html();
		$("#workout").append(o);

		//Call workoutchange method to update text boxes
		workoutChange();
	};

	//getCatagoryID
	function getCatagoryID(){
		return $( "#workoutCat" ).val();
	};

	//Get Workout Name
	function getWorkoutName(){
		return $( "#workout option:selected" ).text();
	};

	//Get Catagory Name
	function getCatagoryName(){
		return $( "#workoutCat option:selected" ).text();
	};

	//detect delbutton of list item
	$(document).on('click','.delbutton',function(e){ 
		//get id of delete button
		pressedButtonID = $(this).attr('id'); 
		//spilt
		var delidSpit = pressedButtonID.split("_");
		//add to li for li ID and remove
		var liID = "#li_" + delidSpit[1];
		$(liID).remove();
	});
	

	function getLiID(index) {
		//get li object by index
		obj = $( ".workouts" ).get(index);
		//get id of object
		compID = $(obj).attr('id');
		//spilt
		var idSpit = compID.split("_");
		//return int
		return idSpit[1];
	};

	//returns the number of workouts
	function totalListItems(){
		return $("#sortable").children().length;
	};

	//Save current workout plan
	function savePlan(){
		//Intialise plan variable
		var planName = "";
		var workoutsObj = [];
		//Ensure the concat variable is empty


			//Loop through all workouts
			for (var i = 0; i < totalListItems(); i++) {

				//Get the id of the current selected list item
				id = getLiID(i+1);
				tableID = "#table_" + id;

				unit = $(tableID+" tr:first th:eq(3)").text().replace(":","");

				var obj = {
					index: i+1,
					catagory_name: $(tableID+" tr:first th:eq(1)").text(),
					workout_name: $(tableID+" tr:first th:eq(2)").text(),
					unit: unit,
					amount: $(tableID+" tr:first th:eq(4)").text(),
					weight: $(tableID+" tr:first th:eq(6)").text()
				};

				workoutsObj.push(obj);
				
			};
			
			jsonStr = JSON.stringify(workoutsObj);
			$("#plans").empty();
			$("#plans").val(jsonStr);
			$("#opt").empty();
			$("#opt").val("Save");


		};


	//Applies sortable function
	$("#sortable").sortable();

	//Detects click of Add button
	$("#Add").click(function (e) {
		e.preventDefault();
		var timereps = 0;
		var measurement ="";
		var weight = 0.00;

		//loop through all workouts and set the measurement to the corresponding workout, EG pushups = reps, cycling = time
		for(j=0; j<workoutArr.length;j++){
			if (workoutArr[j].workout_name == getWorkoutName()) {
				if (workoutArr[j].repstime == 0) {
						//reps
						measurement ="Reps";
					} else {
						//time
						measurement ="Duration";
				};
			};
		};

		//Validate Inputs
		if ($("#timereps").val() == ""){
			alert("Please Enter " + measurement);
		}else {
			if ($( "#weight" ).val() == "") {
				weight = 0.00;
			}else {
				weight = $( "#weight" ).val();
		};

			//This count variable allows us to dynamically give an ID to each item within the list.
			count++;
			createListElement(count,getCatagoryName(),getWorkoutName(),measurement,$("#timereps").val(),weight);
		};
	});
</script>
</body>
</html>