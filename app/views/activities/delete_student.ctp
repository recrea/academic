<?php if (isset($success)) { ?>
	$('#notice').removeClass('error');
	$('#notice').html('El estudiante ha sido eliminado del grupo');
	$('#notice').addClass('success');
	$('#row_<?php echo "{$activity_id}_{$group_id}_{$student_id}" ?>').remove();
<?php } else { ?>
	$('#notice').removeClass('success');
	$('#notice').html('Ha ocurrido algún error y el estudiante no ha podido eliminarse. Consulte con el administrador del sistema.');
	$('#notice').addClass('error');
<?php } ?>