<?php
	include_once("functions/func_admin.php");

	$NO_WARN = true;
	echo api_admin(isset($_GET['token']) ? $_GET['token'] : null);

?>
