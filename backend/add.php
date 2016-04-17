<?php
	include_once("../conf.php");
	include_once("../tokens.php");

	$cookie_info = has_session();

	if(has_session() == false){
		delete_cookie("user");
		delete_cookie("token");
		header("Location: ../login.php");
	}

	if(!validate_token($cookie_info['token'])){
		delete_cookie("user");
		delete_cookie("token");
		header("Location: ../login.php");
	}

?>
i am balid
