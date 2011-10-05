<?php $html->addCrumb('Cursos', '/courses'); ?>
<?php $html->addCrumb($subject['Course']['name'], "/courses/view/{$subject['Course']['id']}"); ?>
<?php $html->addCrumb($subject['Subject']['name'], "/subjects/view/{$subject['Subject']['id']}"); ?>
<?php $html->addCrumb("Programación", "/subjects/getScheduledInfo/{$subject['Subject']['id']}"); ?>
<h1>Programación de la asignatura</h1>
<table>
	<thead>
		<tr>
			<th>Tipo de actividad</th>
			<th>Actividad</th>
			<th>Grupo</th>
			<th>Duración</th>
			<th>Pendiente de programación</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($activities as $activity): ?>
			<?php if ($activity['Activity']['duration'] > $activity[0]['scheduled']) {?>
				<tr class="pendant">
			<?php } else { ?>
				<tr>
			<?php }?>
					<td><?php echo $activity['Activity']['type'] ?></td>
					<td><?php echo $activity['Activity']['activity_name'] ?></td>
					<td><?php echo $activity['Group']['group_name'] ?></td>
					<td><?php echo $activity['Activity']['duration'] ?></td>
					<td><?php echo $activity['Activity']['duration'] - $activity[0]['scheduled'] ?></td>
				</tr>
		<?php endforeach;?>
	</tbody>
</table>