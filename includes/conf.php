<?php
	include_once("secrets.php");
	include_once("tokens.php");
	include_once("cookies.php");
	include_once("meta.php");
	global $DEBUG;

	if($DEBUG){
		echo "<div class='alert alert-warning'>Debugging is enabled</div>";
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
	}

	$DEFAULT = "/login.php";
	$LOGIN_EXPIRY_S = 7200;
	$EXT_IP_CHECK = "http://ip-lookup.net/index.php?ip";

	function getConnection(){
		global $server, $database, $username, $password;

		$conn = new PDO("mysql:host=$server;dbname=$database", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $conn;
	}

	function binaryToEnglish($value) {
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
	function startsWith($haystack, $needle) {
  	return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
	}

	function get_404_image() {
		$sqlMaxImg = "SELECT max(id) AS max FROM 404errors";

		$conn = getConnection();
		$result = $conn->query($sqlMaxImg);

		$rand = rand(1, fetchLazy($result)['max']);

		$sqlGetImg = "SELECT url FROM 404errors WHERE id = $rand";
		$sqlUpdViews = "UPDATE 404errors SET views = views + 1 WHERE id = $rand";

		$result = $conn->query($sqlGetImg);
		$conn->query($sqlUpdViews);
		$conn = null;

		return fetchLazy($result)['url'];
	}

	function fetchLazy($result){
		return $result->fetch(PDO::FETCH_LAZY);
	}

	// this automatically checks for cookies, validates them and,
	// if there isn't a valid session, will redirect to login
	function validate_login($next_page){
		$session_token = has_session();
		if($session_token == false){
			if($next_page == null){
				header("Location: /login.php");
			}else{
				header("Location: /login.php?next=".$next_page);
			}
		}

		$result = validate_token($session_token);

		if(!$result){
			if($next_page == null){
				header("Location: /login.php");
			}else{
				header("Location: /login.php?next=".$next_page);
			}
		}
		return true;
	}

	function get_current_year(){
		return date("Y");
	}
?>
