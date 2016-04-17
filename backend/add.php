<?php
	include_once("conf.php");
	include_once("tokens.php");

	if(!isset($_COOKIE['user'])){
		header("Location: $LOGIN");
	}

	$login_token = $_COOKIE['token'];

	if(!validate_token($login_token)){
		deleteCookie("user");
		deleteCookie("token");
		header("Location: ../login.php");
	}
?>

i am balid
