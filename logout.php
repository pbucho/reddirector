<?php
	include_once("includes/conf.php");
	include_once("includes/tokens.php");
	include_once("includes/cookies.php");

	$session_info = cookies_has_session();

	if($session_info == false){
		header("Location: /list.php");
	}

	tokens_revoke_token($session_info['token']);

	cookies_delete_cookie("user");
	cookies_delete_cookie("token");

	header("Location: /login.php?logout=1");
?>
