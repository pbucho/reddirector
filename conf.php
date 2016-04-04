<?php

	include_once("secrets.php");
	
	$DEFAULT = "http://bucho.pt";
	$NOREDIR = array("list","log","login","add");
	
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
	
	function get404Image() {
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

?>
