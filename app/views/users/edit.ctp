<!-- File: /app/views/users/edit.ctp -->
<?php $html->addCrumb('Usuarios', '/users'); ?>
<?php $html->addCrumb("{$user['User']['first_name']} {$user['User']['last_name']}", "/users/view/{$user['User']['id']}"); ?>
<?php $html->addCrumb("Modificar usuario", "/users/edit/{$user['User']['id']}"); ?>

<h1>Modificar usuario</h1>
<?php
	echo $form->create('User', array('action' => 'edit'));
?>
	<fieldset>
	<legend>Datos generales</legend>
		<?php 
			echo $form->input('first_name', array('label' => 'Nombre', 'before' => '<dl><dt>', 'between' => '</dt><dd>', 'after' => '</dd></dl>')); 
			echo $form->input('last_name', array('label' => 'Apellidos', 'before' => '<dl><dt>', 'between' => '</dt><dd>', 'after' => '</dd></dl>'));
			echo $form->input('dni', array('label' => 'DNI', 'before' => '<dl><dt>', 'between' => '</dt><dd>', 'after' => '</dd></dl>'));
			echo $form->input('username', array('label' => 'Correo electrónico', 'before' => '<dl><dt>', 'between' => '</dt><dd>', 'after' => '</dd></dl>'));
			echo $form->input('phone', array('label' => 'Teléfono', 'before' => '<dl><dt>', 'between' => '</dt><dd>', 'after' => '</dd></dl>'));
			echo $form->input('type', array('label' => 'Tipo', 'before' => '<dl><dt>', 'between' => '</dt><dd>', 'after' => '</dd></dl>', 'options' => array("Administrador" => "Administrador", "Administrativo" => "Administrativo" , "Conserje" => "Conserje",  "Profesor" => "Profesor", "Estudiante" => "Estudiante", "Becario" => "Becario")));
		?>
	</fieldset>
	<?php echo $form->input('id', array('type' => 'hidden')); ?>
<?php
	echo $form->end('Modificar');
?>