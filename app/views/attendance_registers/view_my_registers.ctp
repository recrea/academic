<?php 
	$html->addCrumb('Registros de asistencia', "/attendance_registers/view_my_registers"); 
?>

<h1>Registros de asistencia</h1>

<table>
  <thead>
    <th>Fecha</th>
    <th>Activitdad</th>
    <th>Asignatura</th>
    <th>Nº de asistentes</th>
  </thead>
  
  <tbody>
    <?php foreach($attendance_registers as $register): 
      $date = date_create($register['Event']['initial_hour']);
    ?>
      <tr>
				<td><?php echo $html->link($date->format('d-m-Y'), array('action' => 'edit_student_attendance', $register['Event']['id'])) ?></td>
				<td><?php echo $register['Activity']['name'] ?></td>
				<td><?php echo $register['Subject']['name'] ?></td>
				<td><?php echo $register[0]['num_students'] ?></td>  
			</tr>
    <?php endforeach;?>
  </tbody>
</table>

