<!-- File: /app/views/groups/add.ctp -->
<?php $html->addCrumb('Cursos', '/courses'); ?>
<?php $html->addCrumb($subject['Course']['name'], "/courses/view/{$subject['Course']['id']}"); ?>
<?php $html->addCrumb($subject['Subject']['name'], "/subjects/view/{$subject['Subject']['id']}"); ?>
<?php $html->addCrumb('Modificar grupo', "/groups/edit/{$group['Group']['id']}"); ?>


<h1>Modificar grupo</h1>
<?php
	echo $form->create('Group', array('action' => 'edit'));
?>
	<fieldset>
	<legend>Datos generales</legend>
		<?php echo $form->input('name', array('label' => 'Nombre', 'before' => '<dl><dt>', 'between' => '</dt><dd>', 'after' => '</dd></dl>')); ?>
		<?php echo $form->input('type', array('label' => 'Tipo', 'before' => '<dl><dt>', 'between' => '</dt><dd>', 'after' => '</dd></dl>', 'options' => array("Clase magistral" => "Clase magistral", "Seminario" => "Seminario", "Taller/trabajo en grupo" => "Taller/trabajo en grupo", "Práctica en aula" => "Práctica en aula", "Práctica de problemas" => "Práctica de problemas", "Práctica de informática" => "Práctica de informática", "Práctica de microscopía" => "Práctica de microscopía", "Práctica de laboratorio" => "Práctica de laboratorio", "Práctica clínica" => "Práctica clínica", "Práctica externa" => "Práctica externa", "Tutoría" => "Tutoría", "Evaluación" => "Evaluación", "Otra presencial" => "Otra presencial"))); ?>
		<?php echo $form->input('capacity', array('label' => 'Capacidad', 'before' => '<dl><dt>', 'between' => '</dt><dd>', 'after' => '</dd></dl>')); ?>
		<?php echo $form->input('notes', array('label' => 'Observaciones', 'before' => '<dl><dt>', 'between' => '</dt><dd>', 'after' => '</dd></dl>')); ?>
	</fieldset>
		<?php echo $form->input('subject_id', array('type' => 'hidden')); ?>
		<?php echo $form->input('id', array('type' => 'hidden')); ?>
<?php
	echo $form->end('Modificar');
?>
