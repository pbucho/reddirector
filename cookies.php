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

	function get_current_year(){
		return date("Y");
	}

	function has_session(){
		if(isset($_COOKIE['user']) && isset($_COOKIE['token'])){
			return array('user' => $_COOKIE['user'], 'token' => $_COOKIE['token']);
		}else{
			return false;
		}
	}
?>
