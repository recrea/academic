<?php $html->addCrumb('Cursos', '/courses'); ?>

<h1>Cursos</h1>
<div class="actions">
	<ul>
		<?php if ($auth->user('type') == "Administrador") { ?>
			<li><?php echo $html->link('Crear curso', array('action' => 'add')) ?></li>
		<?php }?>
	</ul>
</div>
<div class="view">
	<table>
		<thead>
			<tr>
				<th>Denominación</th>
				<th>Fecha de comienzo</th>
				<th>Fecha de fin</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($courses as $course): ?>
			<tr>
				<td><?php echo $html->link($course['Course']['name'], array('controller' => 'courses', 'action' => 'view', $course['Course']['id'])) ?></td>
				<td><?php echo $course['Course']['initial_date'] ?></td>
				<td><?php echo $course['Course']['final_date'] ?></td>
			</tr>
			<?php endforeach; ?>
			
		</tbody>
	</table>
</div>