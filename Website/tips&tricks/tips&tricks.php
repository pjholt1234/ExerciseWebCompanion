<?php
session_start();
include ('../dbcon.php');
include ('../statfunc.php');
$userID = $_SESSION['id'];

//array of workouts within plans
$sql = "SELECT * FROM plans_workouts WHERE user_ID = '$userID'";
$result = mysqli_query($con,$sql);

//Fetch into associative array
while ($row = $result->fetch_assoc()) {
    $WorkoutsArr[] = $row;
};


//array of workouts within plans
$sql = "SELECT * FROM categories";
$result = mysqli_query($con,$sql);

//Fetch into associative array
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
};



$today = date("Y/m/d");
$sql="SELECT * FROM events WHERE end_event < '$today' AND user_ID = '$userID'";

$favWorkout = findFavWorkout($con,$sql,$WorkoutsArr);
$leastFavWorkout = findLeastFavWorkout($con,$sql,$WorkoutsArr);
$favCategory = findFavCategory(getCategoryArr($con,$sql,$WorkoutsArr));
$leastFavCategory = findLeastFavCategory(getCategoryArr($con,$sql,$WorkoutsArr));
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Tips & Tricks</title>
        <meta charset="UTF-8" />					
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <link rel="stylesheet" href="tips&tricks.css">
    </head>
    <body>
        <div class="contentbox">
            <div id="plans" class = "box">
                <h1>Tips & Tricks</h1>
                <p>Your Youtube Content Tailoured Just For You Based On Your Workout Habits</p>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <form action="#">
                        <input type="hidden" id ="favWorkout" value =<?=$favWorkout?>>
                        <input type="hidden" id ="leastFavWorkout" value =<?=$leastFavWorkout?>>
                        <input type="hidden" id ="favCategory" value = <?=$favCategory?>>
                        <input type="hidden" id ="leastFavCategory" value =<?=$leastFavCategory?>>
                    </form>
                    <div id="plans" class = "box">
                        <div id="results"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- scripts -->
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <script src="app.js"></script>
        <script src="https://apis.google.com/js/client.js?onload=googleApiClientReady"></script>
    </body>
</html>