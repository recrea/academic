<!-- File: /app/views/courses/add.ctp -->
<?php $html->addCrumb('Cursos', '/courses'); ?>
<?php $html->addCrumb('Crear curso', "/courses/add"); ?>

<?php
	echo $form->create('Course');
?>
	<fieldset>
	<legend>Datos generales</legend>
		<?php echo $form->input('name', array('label' => 'Nombre', 'before' => '<dl><dt>', 'between' => '</dt><dd>', 'after' => '</dd></dl>')); ?>
		<?php echo $form->input('initial_date', array('label' => 'Fecha de inicio', 'type' => 'text', 'before' => '<dl><dt>', 'between' => '</dt><dd>', 'after' => '</dd></dl>')); ?>
		<?php echo $form->input('final_date', array('label' => 'Fecha de fin', 'type' => 'text', 'before' => '<dl><dt>', 'between' => '</dt><dd>', 'after' => '</dd></dl>')); ?>
	</fieldset>
<?php
	echo $form->end('Crear');
?>
<script type="text/javascript">
	$(function() {
		<?php 
			echo $dateHelper->datepicker("#CourseInitialDate");
			echo $dateHelper->datepicker("#CourseFinalDate");
		?>
	});
</script>