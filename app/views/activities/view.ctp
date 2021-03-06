<?php 
	$html->addCrumb('Cursos', '/courses'); 
	$html->addCrumb($subject['Course']['name'], "/courses/view/{$subject['Course']['id']}"); 
	$html->addCrumb($subject['Subject']['name'], "/subjects/view/{$subject['Subject']['id']}"); 
	$html->addCrumb($activity['Activity']['name'], "/activities/view/{$activity['Activity']['id']}");
?>

<h1><?php echo $activity['Activity']['name'] ?></h1>

<div class="actions">
	<ul>
		<li><?php echo $html->link('Modificar actividad', array('action' => 'edit', $activity['Activity']['id'])) ?></li>
		<li><?php echo $html->link('Eliminar actividad', array('action' => 'delete', $activity['Activity']['id']), null, 'Cuando elimina una actividad toda su programación asociada. ¿Está seguro que desea borrarlo?') ?></li>
	</ul>
</div>

<div class="view">
	<fieldset>
	<legend>Datos generales</legend>
		<dl>
			<dt>Nombre</dt>
			<dd><?php echo $activity['Activity']['name']?></dd>
		</dl>
		<dl>
			<dt>Tipo</dt>
			<dd><?php echo $activity['Activity']['type'] ?></dd>
		</dl>
		<dl>
			<dt>Duración</dt>
			<dd><?php echo $activity['Activity']['duration'] ?></dd>
		</dl>
		<dl>
			<dt>Observaciones</dt>
			<dd><?php echo $activity['Activity']['notes'] ?></dd>
		</dl>
	</fieldset>
	
	<?php if (count($groups) > 0) { ?>
		<fieldset>
		<legend>Grupos con estudiantes</legend>
			<table>
				<tr>
					<th>Grupo</th>
					<th>Nº de estudiantes</th>
				</tr>
				<?php foreach($groups as $group): ?>
					<tr>
						<td><?php echo $html->link($group['Group']['name'], array('action' => 'view_students', $activity['Activity']['id'], $group['Group']['id']))?></td>
						<td><?php echo $group[0]['students']?></td>
					</tr>
				<?php endforeach;?>
			</table>
		</fieldset>
	<?php }?>
</div>