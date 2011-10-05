<?php 
	$html->addCrumb('Registros de impartición', '/attendance_registers'); 
	$html->addCrumb('Ver registro de impartición', "/attendance_registers/view/{$ar['AttendanceRegister']['id']}"); 
?>

<h1>Examinar registro de impartición</h1>

<div class="actions">
	<ul>
		<li><?php echo $html->link('Modificar registro', array('action' => 'edit', $ar['AttendanceRegister']['id'])) ?></li>
	</ul>
</div>
<div class="view">
	<fieldset>
	<legend>Datos de la actividad</legend>
		<dl>
			<dt>Asignatura</dt>
			<dd><?php echo $subject['Subject']['name'] ?></dd>
		</dl>
		
		<dl>
			<dt>Actividad</dt>
			<dd><?php echo $ar['Activity']['name'] ?></dd>
		</dl>
		
		<dl>
			<dt>Fecha</dt>
			<dd><?php
			 	$initial_hour = date_create($ar['AttendanceRegister']['initial_hour']);
				$final_hour = date_create($ar['AttendanceRegister']['final_hour']);
				echo $initial_hour->format('d-m-Y'); 
			?></dd>
		</dl>
		
		<dl>
			<dt>Hora de inicio</dt>
			<dd><?php echo $initial_hour->format('H:i') ?></dd>
		</dl>
		
		<dl>
			<dt>Hora de fin</dt>
			<dd><?php echo $final_hour->format('H:i') ?></dd>
		</dl>
		
		<dl>
			<dt>Profesor</dt>
			<dd><?php echo "{$ar['Teacher']['first_name']} {$ar['Teacher']['last_name']}" ?></dd>
		</dl>
		
		<?php if (isset($ar['Teacher_2']['id'])) { ?>
		  <dl>
  			<dt>2º Profesor</dt>
  			<dd><?php echo "{$ar['Teacher_2']['first_name']} {$ar['Teacher_2']['last_name']}" ?></dd>
  		</dl>
		<?php }?>
		
		<dl>
			<dt>Duración</dt>
			<dd><?php echo $ar['AttendanceRegister']['duration'] ?></dd>
		</dl>
	</fieldset>
	
	<fieldset>
	<legend>Estudiantes</legend>
		<table>
			<thead>
				<tr>
					<th>Estudiante</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($ar['Student'] as $student):?>
					<tr>
						<td><?php echo "{$student['first_name']} {$student['last_name']}" ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</fielset>
</div>