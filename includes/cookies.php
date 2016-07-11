<?php
	include_once("conf.php");

	function create_or_update_cookie_no_exp($name, $value){
		$exp = time() + (62208000); // 2yrs
		create_or_update_cookie($name, $value, $exp);
	}

	function delete_cookie($name){
		$exp = time() - 10;
		create_or_update_cookie($name, "", $exp);
	}

	function create_or_update_cookie($name, $value, $exp){
		setcookie($name, $value, $exp);
	}

	// if existing, returns the content of the token cookie
	function has_session(){
		if(isset($_COOKIE['token'])){
			return $_COOKIE['token'];
		}else{
			return false;
		}
	}
?>
