<?php if (isset($success)) { ?>
	<td><?php echo $subject['Subject']['name'] ?></td>
	<td><?php echo $html->link('Eliminar', array('action' => 'delete_subject', $user['User']['id'], $subject['Subject']['id']), null, '¿Está seguro que desea continuar? La asignatura se eliminará con carácter inmediato y el estudiante será eliminado de todos los grupos en los que se haya apuntado.') ?></td>
<?php } else 
	echo "error";
?>
	