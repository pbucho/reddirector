<?php
	// This will receive short URL and return the corresponding long URL.
	// The JSON response will include:
	//		success : boolean - if the translation was successful
	//		shorturl : string - (if success == true) the provided short URL for confirmation.
	//		longurl : string - (if success == true) the corresponding long URL.
	//		reason : string - (if success == false) the reason why the translation was not successful.
	include_once("functions/func_translate.php");

	$NO_WARN = true;
	echo api_translate(isset($_GET['shorturl']) ? $_GET['shorturl'] : null);

?>
