<?php if ($ok){ ?>
	
	$('#notice').removeClass('error');
	$('#notice').html('El evento se ha actualizado correctamente.');
	$('#notice').addClass('success');
	
<?php } else {?>
	
	$('#notice').removeClass('success');
	$('#notice').addClass('error');
	$('#notice').html("Ha ocurrido algún error y el evento no ha podido actualizarse correctamente");
	
<?php } ?>