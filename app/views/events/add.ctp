<?php if (isset($eventExceedDuration)) {?>
	$('#notice').removeClass('success');
	$('#notice').addClass('error');
	$('#notice').html("Los eventos no han podido programarse porque exceden la duración de la actividad");
<?php } else { 

if (isset($events)) { ?>
	if (currentEvent != null){
		$('#calendar').fullCalendar('removeEventSource', currentEvent);
		$('#calendar').fullCalendar('refetchEvents');
	}
	events = [<?php 
		$events_array = array();
		foreach($events as $event):
			$initial_date = date_create($event['Event']['initial_hour']);
			$final_date = date_create($event['Event']['final_hour']);
			
			array_push($events_array, "{id: '{$event['Event']['id']}', title: '{$event['Activity']['name']} ({$subject['Subject']['acronym']})', start: '{$initial_date->format('Y-m-d H:i:s')}', end: '{$final_date->format('Y-m-d H:i:s')}', allDay:false, className: '{$activityHelper->getActivityClassName($event['Activity']['type'])}'}");
		endforeach;
		echo implode($events_array, ",");
	?>];
	$('#form_container').hide();
	$('#notice').removeClass('error');
	$('#notice').html('Los eventos se han añadido correctamente');
	$('#notice').addClass('success');
	$('#calendar').fullCalendar('addEventSource', events);
	$('#calendar').fullCalendar('refetchEvents');
	$('#calendar').fullCalendar('render');

<?php } else { ?>
		$('#notice').removeClass('success');
		$('#notice').addClass('error');
		$('#notice').html("<?php 
		$initial_date = date_create($event['Event']['initial_hour']);
		echo "No ha sido posible crear el evento en la fecha señalada porque coincide el día <strong>{$initial_date->format('d-m-Y')}</strong> con la actividad <strong>{$activity['Activity']['name']}</strong> de la asignatura <strong>{$activity['Subject']['name']}</strong>\");"; 
} }?>
