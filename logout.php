<?php
	include_once("conf.php");
	include_once("tokens.php");

	$session_info = has_session();

	if($session_info == false){
		header("Location: /list.php");
	}

	revoke_token($session_info['token']);

	delete_cookie("user");
	delete_cookie("token");

	header("Location: /login.php?logout=1");
?>
