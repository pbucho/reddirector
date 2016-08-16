<?php
	include_once("base.php");

	function cookies_cookies_create_or_update_cookie_no_exp($name, $value){
		$exp = time() + (62208000); // 2yrs
		cookies_create_or_update_cookie($name, $value, $exp);
	}

	function cookies_delete_cookie($name){
		$exp = time() - 10;
		cookies_create_or_update_cookie($name, "", $exp);
	}

	function cookies_create_or_update_cookie($name, $value, $exp){
		setcookie($name, $value, $exp);
	}

	// if existing, returns the content of the token cookie
	function cookies_has_session(){
		if(isset($_COOKIE['token'])){
			return $_COOKIE['token'];
		}else{
			return false;
		}
	}
?>
