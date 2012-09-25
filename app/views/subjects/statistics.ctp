<?php
	$this->Html->addCrumb('Cursos', '/courses');
	$this->Html->addCrumb($subject['Course']['name'], "/courses/view/{$subject['Course']['id']}");
	$this->Html->addCrumb($subject['Subject']['name'], "/subjects/view/{$subject['Subject']['id']}");
	$this->Html->addCrumb("Estadísticas asignatura", "/subjects/statistics/{$subject['Subject']['id']}");

	echo $this->Html->css('subjects', null, array('inline' => false));
?>

<h1>Estadísticas asignatura</h1>
<div class="view">
  <fieldset>
	  <legend>Resumen por actividad</legend>
		<table class="subject-statistics">
			<thead>
				<tr>
					<th class="date">Fecha</th>
					<th class="activity">Actividad</th>
					<th class="duration">Duración</th>
				</tr>
			</thead>
			<tbody>
				<?php $totalDuration = 0.0 ?>
				<?php foreach ($activities as $activity): ?>
					<?php $totalDuration += $activity[0]['activity_total'] ?>
					<tr>
						<td class="date"><?php echo date('d-m-Y H:i', strtotime($activity['AttendanceRegister']['initial_hour'])) ?></td>
						<td class="activity">
							<?php echo $this->Html->link($activity['Activity']['name'], array('controller' => 'activities', 'action' => 'view', $activity['Activity']['id'])) ?>
						</td>
						<td class="duration"><?php echo sprintf('%.2f', $activity[0]['activity_total']) ?></td>
					</tr>
				<?php endforeach; ?>
				<tr>
					<td class="duration total-duration" colspan="2">TOTAL:</td>
					<td class="duration total-duration"><?php echo sprintf('%.2f', $totalDuration) ?></td>
				</tr>
			</tbody>
		</table>
	</fieldset>

  <fieldset>
	  <legend>Horas impartidas</legend>
		<table class="subject-statistics">
			<thead>
				<tr>
					<th class="date">Fecha</th>
					<th class="activity">Actividad</th>
					<th class="group">Grupo</th>
					<th class="teacher">Profesor 1</th>
					<th class="teacher">Profesor 2</th>
					<th class="duration">Duración</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($registers as $register): ?>
					<tr>
						<td class="date"><?php echo date('d-m-Y H:i', strtotime($register['AttendanceRegister']['initial_hour'])) ?></td>
						<td class="activity">
							<?php echo $this->Html->link($register['Activity']['name'], array('controller' => 'activities', 'action' => 'view', $register['Activity']['id'])) ?>
						</td>
						<td class="group">
							<?php echo $this->Html->link($register['Group']['name'], array('controller' => 'groups', 'action' => 'view', $register['Group']['id'])) ?>
						</td>

						<td class="teacher"><?php echo sprintf('%s %s', $register['Teacher']['first_name'], $register['Teacher']['last_name']) ?></td>
						<td class="teacher"><?php echo sprintf('%s %s', $register['Teacher_2']['first_name'], $register['Teacher_2']['last_name']) ?></td>
						<td class="duration"><?php echo sprintf('%.2f', $register['AttendanceRegister']['duration']) ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</fieldset>
</div>