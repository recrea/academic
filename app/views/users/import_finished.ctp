<!-- File: /app/views/users/new.ctp -->
<?php $html->addCrumb('Usuarios', '/users'); ?>
<?php $html->addCrumb('Importar estudiantes', '/users/import'); ?>

<h1>Importación finalizada</h1>
<p>Se han importado <strong><?php echo $imported_students; ?></strong> estudiante/s.</p>
<?php if (($inexistent_subjects == "") || ($inexistent_subjects == " ")) { ?>
	<p>Las siguientes asignaturas no se han podido importar ya que no figuran en el sistema:</p>
	<br/>
	<?php 
		foreach ($inexistent_subjects as $subject): 
			echo "{$subject}<br/>";
		endforeach; 
	?>
<?php } ?>