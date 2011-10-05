<?php $html->addCrumb('Mis asignaturas', '/users/my_subjects'); ?>
<?php $html->addCrumb($activity['Subject']['name'], "/events/register_student/{$activity['Subject']['id']}"); ?>
<?php $html->addCrumb("Ver alumnos apuntados", "/registrations/{$activity['Activity']['id']}/{$group['Group']['id']}"); ?>

<h2><?php echo "Alumnos apuntados al grupo {$group['Group']['name']} de la actividad {$activity['Activity']['name']}"?></h2>
<table>
	<thead>
		<th>Nombre</th>
	</thead>
	<tbody>
		<?php
			foreach($registrations as $registration):
				echo "<tr><td>{$registration['User']['first_name']} {$registration['User']['last_name']}</td>";
			endforeach;
		?>
	</tbody>
</table>
<?php if (count($registrations) == 0) { ?>
	<p>Todavía no hay ningún estudiante apuntado a este grupo.</p>
<?php } ?>
