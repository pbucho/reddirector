<?php

	include_once("conf.php");

	function validToken($token){
		$sqlValidate = "SELECT expiry, revoked FROM tokens WHERE value = '$token'";
		
		$conn = getConnection();
		$result = $conn->query($sqlValidate);
		$conn = null;
		$result = $result->fetch(PDO::FETCH_LAZY);
		
		if($result == false){
			return false;
		}
		
		if(strcmp($result['revoked'], "1") === 0){
			return false;
		}
		
		$expiry = new DateTime($result['expiry'], new DateTimeZone("UTC"));
		$expiry = $expiry->getTimestamp();
		$now = time();
		
		if($expiry - $now > 0){
			return true;
		}else{
			return false;
		}
		
		// TODO finish
	}
	
	function generateToken($user){
		// TODO
	}
	
	function revokeToken($token){
		// TODO
	}

?>
