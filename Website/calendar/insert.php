<?php

//insert.php

$connect = new PDO('mysql:host=localhost;dbname=exercise_web_companion', 'root', '');

if(isset($_POST["title"]))
{


 $query = "
 INSERT INTO events 
 (title, user_ID, start_event, end_event, plan_ID, allDay) 
 VALUES (:title, :user_ID, :start_event, :end_event, :plan_ID, :allDay)
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':title'  => $_POST['title'],
   ':user_ID'  => $_POST['user_ID'],
   ':start_event' => $_POST['start'],
   ':end_event' => $_POST['end'],
   ':plan_ID' => $_POST['plan_ID'],
   ':allDay' => $_POST['allDay']
  )
 );
}


?>