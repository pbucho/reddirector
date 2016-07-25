<?php
	include_once("functions/func_terminatesessions.php");
	
	$NO_WARN = true;
	echo api_terminate_sessions(isset($_GET['token']) ? $_GET['token'] : null);
	
?>
