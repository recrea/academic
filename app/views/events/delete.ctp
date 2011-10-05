
<?php foreach($events as $event): ?>
	$('#calendar').fullCalendar('removeEvents', <?php echo $event['Event']['id']; ?>);
<?php endforeach; ?>

$('#calendar').fullCalendar('refetchEvents');
$('#edit_form').dialog('close');