<?php
	$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
	include_once($DOC_ROOT."/includes/base.php");
	include_once($DOC_ROOT."/includes/roles.php");
	include_once($DOC_ROOT."/includes/cache.php");
	include_once($DOC_ROOT."/includes/logger.php");
	include_once("func_authenticate.php");

	function api_remove($token, $shorturl){
		global $ACTION_DEL_URL;
		if(is_null($token)){
			return json_encode(array('success' => false, 'reason' => 'Missing token'));
		}

		if(is_null($shorturl)){
			return json_encode(array('success' => false, 'reason' => 'Missing short URL'));
		}

		if(!json_decode(api_authenticate($token), true)['success']){
			return json_encode(array('success' => false, 'reason' => 'Authentication failure'));
		}

		$conn = base_get_connection();
		$sqlValidate1 = "SELECT short_url, long_url FROM translation WHERE short_url = '$shorturl'";
		$result = $conn->query($sqlValidate1);
		$result = base_fetch_lazy($result);

		if($result == false){
			$conn = null;
			return json_encode(array('success' => false, 'reason' => 'Unknown short URL'));
		}

		$sqlRemove = "DELETE FROM translation WHERE short_url = '$shorturl'";
		$userid = cache_get_cached_user_id($token);
		$longurl = $result['long_url'];
		if(roles_is_admin(cache_get_cached_user($token))){
			$result = $conn->query($sqlRemove);
			$conn = null;
			if($result->rowCount() == 1){
				logger_log_action($userid, $ACTION_DEL_URL, $shorturl." &rarr; ".$longurl, null);
				return json_encode(array('success' => true));
			}else{
				return json_encode(array('success' => false, 'reason' => 'Unknown error', 'code' => $result->errorCode()));
			}
		}else{
			$sqlValidate2 = "SELECT t.short_url FROM tokens tk INNER JOIN translation t ON tk.owner = t.owner WHERE tk.value = '$token' AND t.short_url = '$shorturl'";
			$result = $conn->query($sqlValidate2);
			$result = base_fetch_lazy($result);
			if($result == false){
				$conn = null;
				return json_encode(array('success' => false, 'reason' => 'Operation not allowed'));
			}else{
				$result = $conn->query($sqlRemove);
				$conn = null;
				if($result->rowCount() == 1){
					logger_log_action($userid, $ACTION_DEL_URL, $shorturl." &rarr; ".$longurl, null);
					return json_encode(array('success' => true));
				}else{
					return json_encode(array('success' => false, 'reason' => 'Unknown error', 'code' => $result->errorCode()));
				}
			}
		}
	}
?>
