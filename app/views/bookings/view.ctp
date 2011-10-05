<h3><?php echo "{$booking['Booking']['reason']}" ?></h3>
<br/>
<?php
	$initial_date = date_create($booking['Booking']['initial_hour']);
	$final_date = date_create($booking['Booking']['final_hour']);
?>
<p><strong>Hora de inicio:</strong> <?php echo $initial_date->format('H:i') ?></p>
<p><strong>Hora de fin:</strong> <?php echo $final_date->format('H:i') ?></p>

<p><strong>Más información:</strong> <?php echo $booking['Booking']['required_equipment'] ?></p>
<br />
<?php if (isset($auth) && (($auth->user('type') == "Administrador") || ($auth->user('type') == "Conserje"))) { ?>
<p><a href="javascript:;" onclick="deleteBooking(<?php echo $booking['Booking']['id'] ?>, '<?php echo $booking['Booking']['parent_id']?>')">Eliminar reserva</a></p>
<?php } ?>