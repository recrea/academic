<?php
  function get_timestamp($date) { return mktime($date["hour"], $date["minute"], $date["second"]);}
  
  function date_diff_in_hours($d2, $d1) {
    $a = date_parse($d2);
    $b = date_parse($d1);
        
    $timestamp_a = get_timestamp($a);
    $timestamp_b = get_timestamp($b);

    return ($timestamp_a - $timestamp_b) / 3600.0;
  }
?>
<table>
  <thead>
    <tr>
      <th>Fecha</th>
      <th>Nombre de actividad</th>
      <th>Profesor</th>
      <th>Duración</th>
    </tr>
  </thead>
  <tbody>
    <?php 
      $total = 0.0;
      foreach ($registers as $register): 
				$initial_hour = date_create($register['Event']['initial_hour']);
				$final_hour = date_create($register['Event']['final_hour']);
				$duration = date_diff_in_hours($register['Event']['final_hour'], $register['Event']['initial_hour']);
		?>
			<tr>
				<td><?php echo $initial_hour->format('d-m-Y') ?></td>
				<td><?php echo $register['Activity']['name'] ?></td>
				<td><?php echo "{$register['User']['first_name']} {$register['User']['last_name']}" ?></td>
				<td><?php echo $duration ?></td>
				<?php $total += $duration ?>
			</tr>
    <?php endforeach; ?>
  </tbody>
  <tfoot>
    <tr>
      <td></td>
      <td></td>
      <td><strong>TOTAL:</strong></td>
      <td><?php echo $total ?></td>
    </tr>
  </tfoot>
</table>
<?php if (count($registers) == 0) { ?>
  <p>No se ha registrado ninguna actividad a la que este estudiante haya accedido.</p>
<?php } ?>