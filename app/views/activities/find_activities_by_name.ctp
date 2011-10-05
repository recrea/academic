<?php 
	if (count($activities) == 0)
		echo "No existe ninguna actividad con el nombre especificado";
	else {
		foreach ($activities as $activity):	
			echo "{$activity['Activity']['name']}|{$activity['Activity']['id']}\n" ;
		endforeach;
	} 
?>

