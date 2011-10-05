<?php 
	if (count($subjects) == 0)
		echo "No existe ninguna asignatura con el nombre especificado";
	else {
		foreach ($subjects as $subject):	
			echo "{$subject['Subject']['name']}|{$subject['Subject']['id']}\n" ;
		endforeach;
	} 
?>

