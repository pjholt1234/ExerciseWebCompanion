<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Plan A Workout</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link href="planworkout.css" rel="stylesheet" type="text/css">
  <style>
  #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
  #sortable li span { position: absolute; margin-left: -1.3em; }
  </style>
    <?php
  // Connect to database
  include ('dbcon.php');


  //Get Array of catagories from db
  $sql= "SELECT catagory_ID, catagory_name FROM categories";
  $result = mysqli_query($con,$sql);

  while ($row = $result->fetch_assoc()) {
    $catagoryArr[] = $row;
  }


  //Get Array of workouts from db
  $sql = "SELECT * FROM workouts";
  $result = mysqli_query($con,$sql);

  //Initialize array variable
    $workoutArr = array();
  //Fetch into associative array
    while ( $row = $result->fetch_assoc()){
    $workoutArr[]=$row;
    };
  ?>

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
  } );
  </script>
</head>
<body>
 
<div id="workoutPlan" class="workoutPlan">
  <ul class ="workouts" id="sortable">
  </ul>
</div>
 
 <div id="adder" class="buttonBox">
  <label>Select A Catagory And Add A Workout</label><br>
  <select class='select-css' name="workoutCat" id ="workoutCat">
    <?php foreach ($catagoryArr as $row): ?>
        <option value="<?= $row['catagory_ID'] ?>"><?=$row["catagory_name"]?></option>
    <?php endforeach ?>
  </select>
    <select class='select-css' name="workout" id ="workout">
  </select>


    <input type='text' id='timereps' placeholder ='' name='text'size='6'>

    <input type='text' id='weight' placeholder ='Weight - KG'name='text'size='6'>

  <input class='button' type='submit' value='Add' id='Add'/>
  <input class='button' type='submit' value='Save'id='Save'/>

</div>

<div id='somediv'> </div>
<script>


var count = 0;
var buttonPressed = "";


$(window).on('load', function () {
  catagoryChange(); 
});

// pass PHP variable declared above to JavaScript variable
var workoutArr = <?php echo json_encode($workoutArr) ?>;  
var catagoryArr = <?php echo json_encode($catagoryArr) ?>; 

//declare variables 
var catagory_ID = $("select[name='workoutCat']").val();
var catagory_name = "";
var chosenWorkoutArr = new Array();

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

function catagoryChange(){      
    var z = 0;

    //loop through workout array and find all workouts under the chosen catagory
    $('#workout').empty()

    for(i=0; i<workoutArr.length;i++){
      if (workoutArr[i].catagory_ID == getCatagoryID()) {

        z++;
        var o = new Option(workoutArr[i].workout_name, z);
        //jquerify the DOM object 'o' so we can use the html method
        $(o).html(workoutArr[i].workout_name);
        $("#workout").append(o);

    };
  };
  workoutChange();
}

function getCatagoryID(){
  return $( "#workoutCat" ).val();
}

function getWorkoutName(){
  return $( "#workout option:selected" ).text();
}

function getCatagoryName(){
  return $( "#workoutCat option:selected" ).text();
}

function del(){
  $("input").click(function() { 

    pressedButtonID = $(this).attr('id'); 
    pressedButtonClass = $(this).attr('class'); 

    if (pressedButtonClass == "delbutton") {
      var idSpit = pressedButtonID.split(" ");
      $( "#li"+ idSpit[1] ).remove();
    }
  });
};
//detect change in workout catagory.
$("#workoutCat").change(function() {
  catagoryChange();
});

//function to find if workout is reps or time.
$( "#workout" ).change(function() {
  workoutChange();
});   



$("#sortable").sortable();
$("#Add").click(function (e) {
  e.preventDefault();
  var timereps = 0;
  var measurement ="";
  var weight = 0.00;

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
    }

    //This count variable allows us to dynamically give an ID to each item within our list.
    count++;
    //concatenate to form html
    var str = " " + getWorkoutName() + " " + measurement + ": " + $( "#timereps" ).val() + " Weight: " + weight + "Kg";
    str += "<input class='delbutton' type='submit' value='Del' id='del "+ count +"'/>";

    var $li = $("<li id='li" + count + "'style='height: fit-content;' class='workouts'/>").text(getCatagoryName());

    $("#sortable").append($li);
    $li.append(str);
    $li.prepend("<span class='ui-icon ui-icon-arrowthick-2-n-s'></span>");
    $("#sortable").sortable('refresh');
    del();
  };

});
</script> 
</body>
</html>