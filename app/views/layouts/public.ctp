<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<title>Academic</title>
<link rel="icon" type="image/x-icon" href="<?php echo PATH ?>/favicon.ico"/>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo PATH ?>/favicon.ico"/>
<?php 
	echo $scripts_for_layout;
	echo $javascript->link('jquery'); 
	echo $javascript->link('jquery-ui');
	echo $javascript->link('jquery.autocomplete');
	echo $javascript->link('jquery.tooltip');
	echo $javascript->link('fullcalendar');

	echo $html->css('cake.generic.css');

	if (isset($events_schedule) || isset($bookings_schedule))
		echo $html->css('events.forms.css');
	else
		echo $html->css('generic.forms.css');
		
	echo $html->css('jquery-ui');
	echo $html->css('jquery.autocomplete');
	echo $html->css('fullcalendar.css');
	echo $html->css('jquery.tooltip');
?>


</head>
<body>
<div id="container">
	<div id="header">
			<div class="left">
				<ul class="logo">
					<li>
						<a href="<?php echo PATH?>/calendar_by_classroom">
							<img src="<?php echo PATH?>/img/logo.jpg">
						</a>
					</li>
					<li>
						<img src="<?php echo PATH?>/img/divider.jpg">
					</li>
					<li>
						<a href="http://www.fv.ulpgc.es">
							<img src="<?php echo PATH?>/img/logo_ulpgc.jpg">
						</a>
					</li>
				</ul>
			</div>
	</div>
	
	<div id="content">
		<?php echo $content_for_layout ?>
	</div>

	<div id="footer">
	</div>

</body>
</html>