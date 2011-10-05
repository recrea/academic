<?php
	$days = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");

	$initial_date = date_create($initial_date[0]['initial_date']);
	$final_date = date_create($final_date[0]['final_date']);
	echo "Comienza el: {$initial_date->format('d/m/Y')}<br/>";
	echo "Finaliza el: {$final_date->format('d/m/Y')}<br/><br/>";
	echo "Programación: <ul>";
	foreach($events as $event):
		$index = $event[0]['day'];
		echo "<li>{$days[$index]} {$event[0]['initial_hour']} - {$event[0]['final_hour']}</li>";
	endforeach;
	echo "</ul>";
?>