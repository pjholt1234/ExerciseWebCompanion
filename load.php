<?php

//load.php
session_start();
$userID = $_SESSION['id'];
$connect = new PDO('mysql:host=localhost;dbname=exercise_web_companion', 'root', '');

$data = array();

$query = "SELECT * FROM events WHERE user_ID = '$userID' ORDER BY id";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

foreach($result as $row)
{
 $data[] = array(
  'id'   => $row["id"],
  'user_ID' => $row["user_ID"],
  'title'   => $row["title"],
  'start'   => $row["start_event"],
  'end'   => $row["end_event"],
  'plan_ID'   => $row["plan_ID"],
  'allDay' => boolean($row["allDay"])
 );
}

echo json_encode($data);

function boolean($val)
{
    if ($val == 1) {
    	return true;
    }else{
    	return false;
    }
}
?>