<?php foreach($bookings as $booking): ?>
	$('#calendar').fullCalendar('removeEvents', '<?php echo "booking_{$booking['Booking']['id']}"; ?>');
<?php endforeach; ?>

$('#calendar').fullCalendar('refetchEvents');
$('#edit_form').dialog('close');