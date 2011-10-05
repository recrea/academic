<?php 
	foreach ($free_seats as $fs): 
	?>
	$('#free_seats_<?php echo "{$fs['Activity']['id']}_{$fs['Group']['id']}"?>').html("Quedan <?php echo $fs[0]['free_seats'] ?> plazas libres");
<?php
	endforeach;
?>