<?php
	// This will receive a token via GET request and will authenticate it.
	// The JSON response will include:
	//		success : boolean - if the token was successfully authenticated.
	//		user : string - (if success == true) the user name of the given token.
	//		reason : string - (if success == false) the reason why the authentication was not successful.
	include_once("functions/func_authenticate.php");
	
	$NO_WARN = true;
	echo api_authenticate(isset($_GET['token']) ? $_GET['token'] : null);
	
?>
