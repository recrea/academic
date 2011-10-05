var events = [
<?php 
	
	$bookings_array = array();
	foreach($bookings as $booking):
		$initial_date = date_create($booking['Booking']['initial_hour']);
		$final_date = date_create($booking['Booking']['final_hour']);
		array_push($bookings_array,"{id: 'booking_{$booking['Booking']['id']}', start: '{$initial_date->format('Y-m-d H:i:s')}', end: '{$final_date->format('Y-m-d H:i:s')}', title: '{$booking['Booking']['reason']}', allDay: false, className: 'booking'}");
	endforeach;
	echo implode($bookings_array, ",");
?>
];
$('#calendar').fullCalendar('addEventSource', events);
$('#calendar').fullCalendar('refetchEvents');
