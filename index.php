<?php
	include_once("conf.php");
	
	$DEFAULT = "http://bucho.pt";
	
	if(!isset($_GET['short'])){
		header("Location: $DEFAULT");
		die;
	}

	$short_url = $_GET['short'];
	$sql = "SELECT long_url FROM translation WHERE short_url = '$short_url'";
	$sqlUpd = "UPDATE translation SET views = views + 1 WHERE short_url = '$short_url'";
	
	if(strcmp($short_url, "list") == 0){
		header("Location: /list.php");
		die;
	}
	
	$conn = getConnection();
	$result = $conn->query($sql);
	
	$result = $result->fetch(PDO::FETCH_LAZY);
	
	$ip = $_SERVER['REMOTE_ADDR'];
	$sqlReq = "INSERT INTO requests (request, ip, ok) VALUES ('$short_url', '$ip',";
	
	if(!isset($result['long_url'])){
		$sqlReq .= "'0')";
		$conn->query($sqlReq);
		$conn = null;
		header("Location: $DEFAULT");
		die;
	}
	
	$long_url = $result['long_url'];
	$conn->query($sqlUpd);
	
	$sqlReq .= "'1')";
	$conn->query($sqlReq);
	
	$conn = null;
	
	header("Location: $long_url");
	
?>