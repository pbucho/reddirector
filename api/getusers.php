<?php
	include_once("functions/func_getusers.php");

	$NO_WARN = true;
	echo api_getusers(isset($_GET['token']) ? $_GET['token'] : null);

?>
