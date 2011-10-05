<?php
header('Content-type: text');
header('Content-Disposition: attachment; filename="'.$filename.'"');
echo $content_for_layout;
die();
?>