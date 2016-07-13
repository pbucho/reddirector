<?php
	// This will receive a short URL, a long URL and, optionally, a token.
	// Then it will add the short URL to the database.
	// The JSON response will include:
	//		success : boolean - if the URL was successfully added.
	//		shorturl : string - (if success == true) the provided short URL for confirmation
	//		longurl : string - (if success == true) the provided long URL for confirmation
	//		owner : string - (if success == true) the owner of the URL if the token was provided and successfully authenticated. Otherwise, owner is NULL.
	//		reason : string - (if success == false) the reason why the authentication was not successful.
	//		code : string - (if success == false and reason == "Unknown error") a code for error description.
	include_once("functions/func_add.php");

	$NO_WARN = true;
	echo api_add(isset($_GET['token']) 	 ? $_GET['token'] 	 : null,
				 isset($_GET['shorturl']) ? $_GET['shorturl'] : null,
				 isset($_GET['longurl'])  ? $_GET['longurl']  : null);

?>
