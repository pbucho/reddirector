<?php

	include_once("secrets.php");

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$DEFAULT = "list.php";
	$NOREDIR = array("list","log","login","add");
	$LOGIN_EXPIRY_S = 7200;

	$EXT_IP_CHECK = "http://ip-lookup.net/index.php?ip";

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	function getConnection(){
		global $server, $database, $username, $password;

		$conn = new PDO("mysql:host=$server;dbname=$database", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $conn;
	}

	function isNoRedir($string) {
		global $NOREDIR;

		foreach($NOREDIR as $word){
			if(strcmp($string, $word) === 0){
				return true;
			}
		}
		return false;
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
			return $_COOKIE['user'];
		}else{
			return false;
		}
	}

?>
