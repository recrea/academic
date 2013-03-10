<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Agenda diaria</title>
</head>

<body style="font:9pt Arial, Hevetica, sans-serif;">
<?php
$continue = true;
$first_page = true;
$i = 0;
$max_per_page = 16;
?>

<?php for (;$continue;): ?>
	<?php if (!$first_page): ?>
	<p style="page-break-after: always"></p><br />
	<?php endif; ?>

	<table width="95%" border="0" align="center">
		<tr>
			<td><img src="<?php echo PATH."/" ?>img/logoulpgc.gif" /></td>
		</tr>

		<?php if ($first_page): ?>
		<tr>
			<td>
				<div style="border: 1px #000 solid; font-size: 200%; padding-top: 0.25em; padding-left: 0.5em; padding-bottom: 0.25em; margin: 0">
					<strong>Fecha</strong>: <?php echo $date->format('d/m/Y') ?>
				</div>
			</td>
		</tr>
		<?php endif ?>
	</table>

	<table style="width:95%; border:1px #000 solid;" border="0" align="center" cellpadding="0" cellspacing="0">
		<thead>
			<tr style="font:bold">
				<th style="width:5%;border:1px #000 solid">Hora inicio</th>
				<th style="width:5%;border:1px #000 solid">Hora fin</th>
				<th style="width:25%;border:1px #000 solid">Aula</th>
				<th style="width:30%;border:1px #000 solid">Asignatura</th>
				<th style="width:20%;border:1px #000 solid">Profesor</th>
				<th style="width:15%;border:1px #000 solid">Observaciones</th>
			</tr>
		</thead>
		<tbody>
			<?php for($j = 0;($i < count($events)) && ($j < $max_per_page);$i++, $j++): ?>
			<tr style="padding-top:0.1em;height:2.5em">
				<td style="text-align:center; border:1px #000 solid">
					<?php $initial_hour = date_create($events[$i]['Event']['initial_hour']); ?>
					<?php echo "{$initial_hour->format('H:i')}" ?>
				</td>
				<td style="text-align:center; border:1px #000 solid">
					<?php $final_hour = date_create($events[$i]['Event']['final_hour']); ?>
					<?php echo "{$final_hour->format('H:i')}" ?>
				</td>
				<td style="text-align:left; padding-left:0.2em; border:1px #000 solid">
					<?php echo "{$events[$i]['Classroom']['name']}"?>
				</td>
				<td style="text-align:left; padding-left:0.2em; border:1px #000 solid">
					<?php echo "{$events[$i]['Subject']['name']}"?>
				</td>
				<td style="padding-left:0.2em; border:1px #000 solid">
					<?php echo "{$events[$i]['Teacher']['first_name']} {$events[$i]['Teacher']['last_name']}"?>
				</td>
				<td style="padding-left:0.2em; border:1px #000 solid"></td>
			</tr>
			<?php endfor ?>				

			<?php if ($i >= count($events)): ?>
				<?php $continue = false ?>
				<?php for ($k=0; $k<3; $k++): ?>
				<tr style="padding-top:0.1em;height:2.5em">
					<td style="padding-left:0.2em; border:1px #000 solid"></td>
					<td style="padding-left:0.2em; border:1px #000 solid"></td>
					<td style="padding-left:0.2em; border:1px #000 solid"></td>
					<td style="padding-left:0.2em; border:1px #000 solid"></td>
					<td style="padding-left:0.2em; border:1px #000 solid"></td>
					<td style="padding-left:0.2em; border:1px #000 solid"></td>
				</tr>
				<?php endfor ?>
			<?php else: ?>
				<?php $first_page = false; ?>
			<?php endif ?>
		</tbody>
	<table>
<?php endfor ?>
<?php echo $javascript->link('jquery'); ?>
<script type="text/javascript">
$(document).ready(function() {
	window.print();
	});
</script>
</body>
</html>
