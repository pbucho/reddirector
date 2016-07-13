<?php
	include_once("secrets.php");
	include_once("tokens.php");
	include_once("cookies.php");
	include_once("meta.php");
	global $DEBUG;

	if($DEBUG && isset($NO_WARN) && $NO_WARN){
		echo "<div class='alert alert-warning'>Debugging is enabled</div>";
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
	}

	$DEFAULT = "/login.php";
	$LOGIN_EXPIRY_S = 7200;
	$TOKEN_DURATION = 86400; // 24hrs in seconds
	$EXT_IP_CHECK = "http://ip-lookup.net/index.php?ip";

	function conf_get_connection(){
		global $server, $database, $username, $password;

		$conn = new PDO("mysql:host=$server;dbname=$database", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $conn;
	}

	function conf_bin_2_eng($value) {
		if($value === 1){
			return "True";
		}else{
			if(strcmp($value, "1") === 0){
				return "True";
			}
		}
		return "False";
	}

	// from http://stackoverflow.com/a/10473026
	function conf_starts_with($haystack, $needle) {
  	return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
	}

	function conf_get_404_image() {
		$sqlMaxImg = "SELECT max(id) AS max FROM 404errors";

		$conn = conf_get_connection();
		$result = $conn->query($sqlMaxImg);

		$rand = rand(1, conf_fetch_lazy($result)['max']);

		$sqlGetImg = "SELECT url FROM 404errors WHERE id = $rand";
		$sqlUpdViews = "UPDATE 404errors SET views = views + 1 WHERE id = $rand";

		$result = $conn->query($sqlGetImg);
		$conn->query($sqlUpdViews);
		$conn = null;

		return conf_fetch_lazy($result)['url'];
	}

	function conf_fetch_lazy($result){
		return $result->fetch(PDO::FETCH_LAZY);
	}

	// this automatically checks for cookies, validates them and,
	// if there isn't a valid session, will redirect to login
	function conf_validate_login($next_page){
		$session_token = cookies_has_session();
		if($session_token == false){
			if(is_null($next_page)){
				header("Location: /login.php");
			}else{
				header("Location: /login.php?next=".$next_page);
			}
		}

		$result = tokens_validate_token($session_token);

		if(!$result){
			if(is_null($next_page)){
				header("Location: /login.php");
			}else{
				header("Location: /login.php?next=".$next_page);
			}
		}
		return true;
	}

	function conf_get_current_year(){
		return date("Y");
	}
?>
