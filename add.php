<?php
	include_once("conf.php");
	include_once("tokens.php");
	
	global $LOGIN;
	
	if(!isset($_COOKIE['login'])){
		header("Location: $LOGIN");
	}
	
	$login_token = $_COOKIE['login'];
	
	if(!validToken($login_token)){
		deleteCookie("login");
		header("Location: $LOGIN");
	}
?>
