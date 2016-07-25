<?php
	include_once("includes/conf.php");
	include_once("includes/tokens.php");
	include_once("includes/cookies.php");

	$session_token = cookies_has_session();

	if($session_token == false){
		header("Location: /list.php");
	}

	tokens_revoke_token($session_token);

	cookies_delete_cookie("user");
	cookies_delete_cookie("token");

	header("Location: /login.php?logout=1");
?>
