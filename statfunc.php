<?php
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
function findLeastFavWorkout($con,$sql,$WorkoutsArr){
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
			$minVal = min($favWorkoutArr);

			//Use array_search to find the key that
			//the max value is associated with
			$minKey = array_search($minVal, $favWorkoutArr);
			return $minKey;
		}else{
			return "Crunch";
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
				for ($z=0; $z <count($WorkoutsArr); $z++) { 
					//find matching plan ID's
					if ($events[$i]["plan_ID"] == $WorkoutsArr[$z]["plan_ID"]) {


						//if the array key exists add 1;
						if (array_key_exists($WorkoutsArr[$z]["catagory_name"],$favCategoryArr)){
							$favCategoryArr[$WorkoutsArr[$z]["catagory_name"]]++;
							
						}
						elseif (!array_key_exists($WorkoutsArr[$z]["catagory_name"],$favCategoryArr)){
						//if not create a new item with the key of the workout name and give it a value of 1;
						  $favCategoryArr[$WorkoutsArr[$z]["catagory_name"]] = 1;
						}

					}
				}
			}
			
			return $favCategoryArr;
		}else{

			return $favCategoryArr = array('none' => 0);
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
			//Use array_search to find the key that
			//the max value is associated with
		if (count($catArr)> 1) {
			$maxKey = array_search(max($catArr), $catArr);
			return $maxKey;
		}else{
			reset($catArr);
			$first_key = key($catArr);
			return $first_key;
		}

	};

	function findLeastFavCategory($catArr){
			//Find the highest value in the array
			//by using PHP's max function.
			//Use array_search to find the key that
			//the max value is associated with
			$minKey = array_search(min($catArr), $catArr);
			return $minKey;
		if (count($catArr)> 1) {
			$minKey = array_search(min($catArr), $catArr);
			return $minKey;
		}else{
			return "Cardio";
		}
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
	

	function workoutStats($con,$sql,$WorkoutsArr,$allWorkouts){
		$result = mysqli_query($con,$sql);
		while ($row = $result->fetch_assoc()) {
			$events[] = $row;
		};

		if (empty($events)) {
			$noPlansArr = array('plan_ID' => "na");
			$events = array($noPlansArr);
		}

		$workoutStatsArr = Array();

		for ($i=0; $i <count($allWorkouts) ; $i++) {

			${$allWorkouts[$i]["workout_name"]} = Array("workout_ID" => $allWorkouts[$i]["workout_ID"],
														"workout_name" => $allWorkouts[$i]["workout_name"],
														"totalUnit" => totalUnit($allWorkouts[$i]["workout_ID"],$WorkoutsArr,$events,$allWorkouts),
														"totalWeight" => totalWeight($allWorkouts[$i]["workout_ID"],$WorkoutsArr,$events),
														"maxUnit" => maxUnit($allWorkouts[$i]["workout_ID"],$WorkoutsArr,$events,$allWorkouts),
														"maxWeight" => maxWeight($allWorkouts[$i]["workout_ID"],$WorkoutsArr,$events),
														"unit" => getWorkoutUnit($allWorkouts, $allWorkouts[$i]["workout_ID"]));
			array_push($workoutStatsArr,${$allWorkouts[$i]["workout_name"]});
		}
		return $workoutStatsArr;
	}

	function totalUnit($workout_ID,$WorkoutsArr,$events,$allWorkouts){
		
		$unit = getWorkoutUnit($allWorkouts, $workout_ID);
		$unitTotal = 0;

		//check if either array is empty
		if(!empty($events) and !empty($WorkoutsArr)){
			//loop through events array
			for ($i=0; $i <count($events) ; $i++) {

				//loop through workouts array
				for ($x=0; $x <count($WorkoutsArr) ; $x++) { 
					//find matching plan ID's
					if ($events[$i]["plan_ID"] == $WorkoutsArr[$x]["plan_ID"] && $WorkoutsArr[$x]["workout_ID"] == $workout_ID) {

						$unitTotal += $WorkoutsArr[$x][$unit];
					}
				}
			}
			return $unitTotal;
		}else{
			return 0;
		};		
	}

	function maxUnit($workout_ID,$WorkoutsArr,$events,$allWorkouts){
		
		$unit = getWorkoutUnit($allWorkouts, $workout_ID);
		$unitMax = 0;

		//check if either array is empty
		if(!empty($events) and !empty($WorkoutsArr)){
			//loop through events array
			for ($i=0; $i <count($events) ; $i++) {

				//loop through workouts array
				for ($x=0; $x <count($WorkoutsArr) ; $x++) { 
					//find matching plan ID's
					if ($events[$i]["plan_ID"] == $WorkoutsArr[$x]["plan_ID"] && $WorkoutsArr[$x]["workout_ID"] == $workout_ID) {

						if ($unitMax < $WorkoutsArr[$x][$unit]) {
							$unitMax = $WorkoutsArr[$x][$unit];
						}
					}
				}
			}
			return $unitMax;
		}else{
			return 0;
		};		
	}
	function totalWeight($workout_ID,$WorkoutsArr,$events){
		
		$weightTotal = 0;

		//check if either array is empty
		if(!empty($events) and !empty($WorkoutsArr)){
			//loop through events array
			for ($i=0; $i <count($events) ; $i++) {

				//loop through workouts array
				for ($x=0; $x <count($WorkoutsArr) ; $x++) { 
					//find matching plan ID's
					if ($events[$i]["plan_ID"] == $WorkoutsArr[$x]["plan_ID"] && $WorkoutsArr[$x]["workout_ID"] == $workout_ID) {

						$weightTotal += $WorkoutsArr[$x]["weight"];
					}
				}
			}
			return $weightTotal;
		}else{
			return 0;
		};		
	}

	function maxWeight($workout_ID,$WorkoutsArr,$events){
		$unitWeight = 0;

		//check if either array is empty
		if(!empty($events) and !empty($WorkoutsArr)){
			//loop through events array
			for ($i=0; $i <count($events) ; $i++) {

				//loop through workouts array
				for ($x=0; $x <count($WorkoutsArr) ; $x++) { 
					//find matching plan ID's
					if ($events[$i]["plan_ID"] == $WorkoutsArr[$x]["plan_ID"] && $WorkoutsArr[$x]["workout_ID"] == $workout_ID) {

						if ($unitWeight < $WorkoutsArr[$x]["weight"]) {
							$unitWeight = $WorkoutsArr[$x]["weight"];
						}
					}
				}
			}
			return $unitWeight;
		}else{
			return 0;
		};		
	}

	function getWorkoutUnit($allWorkouts, $id){
		for ($i=0; $i <count($allWorkouts) ; $i++) {
			if ($allWorkouts[$i]["workout_ID"] == $id) {
				if ($allWorkouts[$i]["repstime"] == 0) {
				 	$unit = "reps";
				}elseif ($allWorkouts[$i]["repstime"] == 1) {
					$unit = "duration";
				}
			}
		}
		return $unit;	
	}
?>