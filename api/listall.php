<?php
	include_once("functions/func_listall.php");

	// Returns all existing URLs. All argumens are optional but minlim and maxlim must be provided
	// simultaneously. If the token belongs to an admin, the response will include the URL owners.
	$NO_WARN = true;
	echo api_listall(isset($_GET['token']) ? $_GET['token'] : null,
					isset($_GET['minlim']) ? $_GET['minlim'] : null,
					isset($_GET['maxlim']) ? $_GET['maxlim'] : null);

?>
