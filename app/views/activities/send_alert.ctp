<?php if (isset($success)) { ?>
	$('#notice').removeClass('error');
	$('#notice').html('La alerta se ha enviado correctamente a todos los estudiantes del grupo');
	$('#notice').addClass('success');
	
<?php } else { ?>
	$('#notice').removeClass('success');
	$('#notice').html('Ha ocurrido algún error y no ha podido enviarse la alerta. Consulte con el administrador del sistema.');
	$('#notice').addClass('error');
<?php } ?>

$('#form').dialog('close');