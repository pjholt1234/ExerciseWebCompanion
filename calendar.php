 <!DOCTYPE html>
<html lang="en">
  <head>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js'></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script> 
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.8.2/fullcalendar.min.js'></script>  
    <meta charset="utf-8">
    <title>Calendar</title>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.8.2/fullcalendar.min.css' rel='stylesheet' />
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.8.2/fullcalendar.print.css' media='print' />
    <link href="calendarstyle.css" rel="stylesheet" type="text/css">
    <?php
      session_start();
      include ('dbcon.php');
      $user_ID = $_SESSION['id']; 
      $sql = "SELECT * FROM plans_workouts WHERE user_ID = '$user_ID'";
      $result = mysqli_query($con,$sql);


      while ( $row = $result->fetch_assoc()){
        $userWorkoutsArr[]=$row;
      };

      //check if userWorkoutsArr is empty to prevent error when passing to javascript
      if (empty($userWorkoutsArr)) {
        $userWorkoutsArr = array("empty" => "empty");  
      }  

      $sql = "SELECT * FROM plans WHERE user_ID = '$user_ID'";
      $result = mysqli_query($con,$sql);

      while ( $row = $result->fetch_assoc()){
        $userPlansArr[]=$row;
      };

      //check if userPlansArr is empty to prevent error when passing to javascript
      if (empty($userPlansArr)) {
        $userPlansArr = array("empty" => "empty");   
      }
    ?>

  </head>
  
<body>
  <div id = "box" class= "box">
    <div id='external-events'>
      <p>
        <strong>Your Workout Plans</strong>
      </p>
      <p>
        <input type='checkbox' id='drop-remove' />
        <label for='drop-remove'>remove after drop</label>
      </p>
      <input type="hidden" class = "user_ID" id="user_ID" value="<?php echo $user_ID; ?>">
    </div>

    <div id='calendar-container'>
      <div id='calendar'></div>
    </div>
  </div>

  <script type="text/javascript">

  var user_ID = $("#user_ID").val();
  appendWorkouts();
  var id = 0;

  $(document).ready(function() {
     $('#external-events .fc-event').each(function() {
        // store data so the calendar knows to render an event upon drop
        $(this).data('event', {
          title: $.trim($(this).text()), // use the element's text as the event
          plan_ID: $(this).attr("id"),
          user_ID: user_ID,
          allDay: true,
          stick: true // maintain when user navigates (see docs on the renderEvent method)
        });

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex: 999,
          revert: true,      // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        });

      });

    var today = new Date();

    $('#calendar').fullCalendar({
      header: {
        right: 'prev,next today', //positions the the prev/next button on the right 
        center: 'title', //sets the title of the month to center
        left: 'month, agendaWeek, agendaDay' //positions the the prev/next button on the left 
      },
      defaultDate: today,
      editable: true,
      eventDurationEditable: true,
      droppable: true, // this allows things to be dropped onto the calendar
      drop: function(event,start) {
          // is the "remove after drop" checkbox checked?
        if ($('#drop-remove').is(':checked')) {
            // if so, remove the element from the "Draggable Events" list
          $(this).remove();
        }
      },
      eventReceive: function(event) {
        var start = event.start;
        var end = event.end || start;

        end = moment(end).format('YYYY/MM/DD HH:mm');
        start = moment(start).format('YYYY/MM/DD HH:mm');
        if (event.allDay) {
          var allDay =  1;
        }else{
          var allDay = 0;
        };
        var plan_ID = event.plan_ID;
          $.ajax({
           url:"insert.php",
           type:"POST",
           data:{user_ID: user_ID, title:event.title, start:start, end:end, plan_ID: plan_ID, allDay: allDay},
           success:function()
           {
            $('#calendar').fullCalendar('refetchEvents');
            location.reload();
            alert("Added Successfully");
           }
        })  
      },
      eventLimit: true, // add "more" link when there are too many events in a day
      eventClick:function(event){
       if(confirm("Are you sure you want to remove it?")){
        var id = event.id;
        $.ajax({
         url:"delete.php",
         type:"POST",
         data:{id:id},
         success:function(){
          $('#calendar').fullCalendar('refetchEvents');
          alert("Event Removed");
         }
        })
       }
      },
      events: 'load.php',
      selectable:true,
      selectHelper:true,
      eventDrop:function(event){

        var start = event.start;
        var end = event.end || start;
        
        end = moment(end).format('YYYY/MM/DD HH:mm');
        start = moment(start).format('YYYY/MM/DD HH:mm');

        var plan_ID = event.plan_ID;
        var title = event.title;
        var id = event.id;
        if (event.allDay) {
          var allDay =  1;
        }else{
          var allDay = 0;
        }
        console.log(allDay);
       $.ajax({
        url:"update.php",
        type:"POST",
        data:{title:title, user_ID: user_ID, start:start, end:end, id:id, plan_ID:plan_ID, allDay: allDay},
        success:function()
        {
         $('#calendar').fullCalendar('refetchEvents');
         alert("Event Updated");
        }
       });
      },
      eventResize:function(event){

        
        end = moment(event.end).format('YYYY/MM/DD HH:mm');
        start = moment(event.start).format('YYYY/MM/DD HH:mm');
        var plan_ID = event.plan_ID;
        var title = event.title;
        var id = event.id;
        if (event.allDay) {
          var allDay =  1;
        }else{
          var allDay = 0;
        }

       $.ajax({
        url:"update.php",
        type:"POST",
        data:{title:title, user_ID: user_ID, start:start, end:end, id:id, plan_ID:plan_ID, allDay: allDay},
        success:function()
        {
         $('#calendar').fullCalendar('refetchEvents');
         alert("Event Updated");
        }
       });  
      }
    });

  });

  function appendWorkouts(){
    var userPlansArr = <?php echo json_encode($userPlansArr) ?>;

    //IF accordion is empty assign text
    if (userPlansArr['empty'] == "empty") {
      console.log("no plans error");
    }else{

      var userPlansArr = <?php echo json_encode($userPlansArr) ?>;
      //loop through plans array
      for (var i = userPlansArr.length - 1; i >= 0; i--) {

        //assign variables
        var plan_name = userPlansArr[i]["plan_name"];
        var plan_ID = userPlansArr[i]["plan_ID"];

        var dataevent;
        dataevent = '{"plan_ID": '+ plan_ID + ', "title": '+plan_name+'}'


        str = "<div class='fc-event' id = "+plan_ID+">"+plan_name+"</div>"

        $(str).appendTo("#external-events"); 
      };
    };

  };

</script>

</body>
</html>