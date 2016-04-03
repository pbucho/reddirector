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

?>
