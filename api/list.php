<?php
	include_once("functions/func_list.php");
	
	$NO_WARN = true;
	echo api_list(isset($_GET['token']) ? $_GET['token'] : null,
				  isset($_GET['minlim']) ? $_GET['minlim'] : null,
				  isset($_GET['maxlim']) ? $_GET['maxlim'] : null);
	
?>
