<?php

//update.php

$connect = new PDO('mysql:host=localhost;dbname=exercise_web_companion', 'root', '');

if(isset($_POST["id"]))
{
 $query = "
 UPDATE events 
 SET title=:title, user_ID=:user_ID, start_event=:start_event, end_event=:end_event, plan_ID=:plan_ID, allDay=:allDay
 WHERE id=:id
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':title'  => $_POST['title'],
   ':user_ID'  => $_POST['user_ID'],
   ':start_event' => $_POST['start'],
   ':end_event' => $_POST['end'],
   ':id'   => $_POST['id'],
   ':plan_ID'   => $_POST['plan_ID'],
   ':allDay' => $_POST['allDay']
  )
 );
}

?>