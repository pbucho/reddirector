<?php
	$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
	include_once($DOC_ROOT."/includes/conf.php");
	include_once($DOC_ROOT."/includes/cache.php");

	function api_authenticate($token){
		if(is_null($token)){
			return json_encode(array('success' => false, 'reason' => 'Missing token'));
		}

		$sqlValidate = "SELECT expiry, revoked FROM tokens WHERE value = '$token'";

		$conn = conf_get_connection();
		$result = $conn->query($sqlValidate);
		$conn = null;
		$result = conf_fetch_lazy($result);

		if($result == false){
			return json_encode(array('success' => false, 'reason' => 'Unknown token'));
		}

		if(strcmp($result['revoked'], "1") === 0){
			return json_encode(array('success' => false, 'reason' => 'Revoked token'));
		}

		$expiry = new DateTime($result['expiry'], new DateTimeZone("UTC"));
		$expiry = $expiry->getTimestamp();
		$now = time();

		if($expiry - $now > 0){
			$user = cache_get_cached_user($token);
			return json_encode(array('success' => true, 'user' => $user));
		}else{
			return json_encode(array('success' => false, 'reason' => 'Expired token'));
		}
	}
?>
