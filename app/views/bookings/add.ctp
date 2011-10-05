<?php 
if (isset($bookings)) { ?>
	if (currentEvent != null){
		$('#calendar').fullCalendar('removeEventSource', currentEvent);
		$('#calendar').fullCalendar('refetchEvents');
	}
	events = [<?php 
		$bookings_array = array();
		foreach($bookings as $booking):
			$initial_date = date_create($booking['Booking']['initial_hour']);
			$final_date = date_create($booking['Booking']['final_hour']);
			
			array_push($bookings_array, "{id: 'booking_{$booking['Booking']['id']}', title: '{$booking['Booking']['reason']}', start: '{$initial_date->format('Y-m-d H:i:s')}', end: '{$final_date->format('Y-m-d H:i:s')}', allDay:false, className: 'booking'}");
		endforeach;
		echo implode($bookings_array, ",");
	?>];
	$('#form_container').hide();
	$('#notice').removeClass('error');
	$('#notice').html('Las reservas se han añadido correctamente');
	$('#notice').addClass('success');
	$('#calendar').fullCalendar('addEventSource', events);
	$('#calendar').fullCalendar('refetchEvents');
	$('#calendar').fullCalendar('render');

<?php } else { ?>
		$('#notice').removeClass('success');
		$('#notice').addClass('error');
		$('#notice').html("<?php 
		echo "No ha sido posible crear la/s reserva/s debido a que coinciden con otra reserva u otra actividad académica";?>");
<?php } ?>
