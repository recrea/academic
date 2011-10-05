<!-- File: /app/views/courses/add.ctp -->
<?php $html->addCrumb('Cursos', '/courses'); ?>
<?php $html->addCrumb("{$course['Course']['name']}", "/courses/view/{$course['Course']['id']}"); ?>
<?php $html->addCrumb("Modificar curso", "/courses/edit/{$course['Course']['id']}"); ?>

<?php
	echo $form->create('Course', array('action' => 'edit'));
?>
	<fieldset>
	<legend>Datos generales</legend>
		<?php echo $form->input('name', array('label' => 'Nombre', 'before' => '<dl><dt>', 'between' => '</dt><dd>', 'after' => '</dd></dl>')); ?>
		<?php echo $form->input('initial_date', array('label' => 'Fecha de inicio', 'type' => 'text', 'before' => '<dl><dt>', 'between' => '</dt><dd>', 'after' => '</dd></dl>')); ?>
		<?php echo $form->input('final_date', array('label' => 'Fecha de fin', 'type' => 'text', 'before' => '<dl><dt>', 'between' => '</dt><dd>', 'after' => '</dd></dl>')); ?>
	</fieldset>
	<?php echo $form->input('id', array('type' => 'hidden')); ?>
<?php
	echo $form->end('Modificar');
?>
<script type="text/javascript">
	$(function() {
		<?php 
			echo $dateHelper->datepicker("#CourseInitialDate");
			echo $dateHelper->datepicker("#CourseFinalDate");
		?>
	});
</script>