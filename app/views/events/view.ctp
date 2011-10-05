<h3><?php echo "{$event['Activity']['name']} ({$subject['Subject']['acronym']})" ?></h3>
<br/>
<p><strong>Asignatura:</strong> <?php echo $subject['Subject']['name'] ?></p>
<p><strong>Tipo de actividad:</strong> <?php echo $event['Activity']['type'] ?></p>
<p><strong>Grupo:</strong> <?php echo $event['Group']['name'] ?></p>
<?php
	$initial_date = date_create($event['Event']['initial_hour']);
	$final_date = date_create($event['Event']['final_hour']);
?>
<p><strong>Hora de inicio:</strong> <?php echo $initial_date->format('H:i') ?></p>
<p><strong>Hora de fin:</strong> <?php echo $final_date->format('H:i') ?></p>
<p>
  <strong>Profesor/es:</strong> 
  <?php echo "{$event['Teacher']['first_name']} {$event['Teacher']['last_name']}"?>
  <?php if ((isset($event['Teacher_2'])) && (isset($event['Teacher_2']['id']))) { ?>
    <?php echo ", {$event['Teacher_2']['first_name']} {$event['Teacher_2']['last_name']}"?>
  <?php } ?>
</p>
<p><strong>Aula:</strong> <?php echo $event['Classroom']['name'] ?></p>
<p><strong>Observaciones:</strong> <?php echo $event['Activity']['notes'] ?>
<br>