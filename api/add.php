<?php
	include_once("../includes/conf.php");
	include_once("../includes/cache.php");
	
	if(!isset($_GET['token'])){
		echo json_encode(array('success' => false, 'reason' => 'Missing token'));
		die;
	}
	
	$token = $_GET['token'];
	echo json_decode(http_get('/api/authenticate.php?token='.$token));
	die;
	
	if(!isset($_GET['shorturl'])){
		echo json_encode(array('success' => false, 'reason' => 'Missing short URL'));
		die;
	}
	
	$short_url = $_GET['shorturl'];
	
	if(!isset($_GET['longurl'])){
		echo json_encode(array('success' => false, 'reason' => 'Missing long URL'));
		die;
	}
	
	$long_url = $_GET['longurl'];

	if(empty($long_url) || empty($short_url)){
		echo json_encode(array('success' => false, 'reason' => 'URL not provided'));
		die;
	}else{
		$conn = conf_get_connection();
		$sqlAdd = "INSERT INTO translation (short_url, long_url, owner) VALUES ('$short_url', '$long_url', ";
		if($token != false) {
			$user_id = cache_get_cached_user_id($token);
			$sqlAdd = $sqlAdd."$user_id)";
		}else{
			$sqlAdd = $sqlAdd."NULL)";
		}
		try{
			$result = $conn->query($sqlAdd);
			$conn = null;
			echo json_encode(array('success' => true, 'reason' => null));
			die;
		}catch(PDOException $e){
			$conn = null;
			if($e->getCode() == 23000){
				echo json_encode(array('success' => false, 'reason' => 'String '.$short_url.' already exists'));
				die;
			}else{
				echo json_encode(array('success' => false, 'reason' => 'Unknown error'));
				die;
			}
		}
	}
?>