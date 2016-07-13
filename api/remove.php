<?php
	// This will receive a short URL and delete it.
	// The JSON response will include:
	//		success : boolean - if the short URL was successfully deleted.
	//		reason : string - (if success == false) the reason why the deletion was not successful.
	include_once("functions/func_remove.php");

	$NO_WARN = true;
	echo api_remove(isset($_GET['token']) ? $_GET['token'] : null,
									isset($_GET['shorturl']) ? $_GET['shorturl'] : null);

?>
