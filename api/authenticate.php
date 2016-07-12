<?php
	include_once("../includes/conf.php");
	
	authenticate($_GET['token']);
	
	function authenticate($token){
		if(!isset($token) || is_null($token)){
			echo json_encode(array('success' => false, 'reason' => 'Missing token'));
			die;
		}
		
		$sqlValidate = "SELECT expiry, revoked FROM tokens WHERE value = '$token'";

		$conn = conf_get_connection();
		$result = $conn->query($sqlValidate);
		$conn = null;
		$result = conf_fetch_lazy($result);

		if($result == false){
			echo json_encode(array('success' => false, 'reason' => 'Unknown token'));
			die;
		}

		if(strcmp($result['revoked'], "1") === 0){
			echo json_encode(array('success' => false, 'reason' => 'Revoked token'));
			die;
		}

		$expiry = new DateTime($result['expiry'], new DateTimeZone("UTC"));
		$expiry = $expiry->getTimestamp();
		$now = time();

		if($expiry - $now > 0){
			echo json_encode(array('success' => true, 'reason' => null));
		}else{
			echo json_encode(array('success' => false, 'reason' => 'Expired token'));
		}
	}
?>