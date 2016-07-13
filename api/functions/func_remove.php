<?php
	$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
	include_once($DOC_ROOT."/includes/conf.php");
	include_once($DOC_ROOT."/includes/roles.php");
	include_once($DOC_ROOT."/includes/cache.php");
	include_once("func_authenticate.php");

	function api_remove($token, $shorturl){
		if(is_null($token)){
			return json_encode(array('success' => false, 'reason' => 'Missing token'));
		}

		if(!json_decode(api_authenticate($token), true)['success']){
			return json_encode(array('success' => false, 'reason' => 'Authentication failure'));
		}

		if(is_null($shorturl)){
			return json_encode(array('success' => false, 'reason' => 'Missing short URL'));
		}

		$conn = conf_get_connection();
		$sqlValidate1 = "SELECT short_url FROM translation WHERE short_url = '$shorturl'";
		$result = $conn->query($sqlValidate1);
		$result = conf_fetch_lazy($result);

		if($result == false){
			$conn = null;
			return json_encode(array('success' => false, 'reason' => 'Unknown short URL'));
		}

		if(roles_is_admin(cache_get_cached_user($token))){
			$sqlRemove = "DELETE FROM translation WHERE short_url = '$shorturl'";
			$result = $conn->query($sqlRemove);
			$conn = null;
			if($result->rowCount() == 1){
				return json_encode(array('success' => true));
			}else{
				return json_encode(array('success' => false, 'reason' => 'Unknown error', 'code' => $result->errorCode()));
			}
		}else{
			$sqlValidate2 = "SELECT t.short_url FROM tokens tk INNER JOIN translation t ON tk.owner = t.owner WHERE tk.value = '$token' AND t.short_url = '$shorturl'";
			$result = $conn->query($sqlValidate2);
			$result = conf_fetch_lazy($result);
			if($result == false){
				$conn = null;
				return json_encode(array('success' => false, 'reason' => 'Operation not allowed'));
			}else{
				$sqlRemove = "DELETE FROM translation WHERE short_url = '$shorturl'";
				$result = $conn->query($sqlRemove);
				$conn = null;
				if($result->rowCount() == 1){
					return json_encode(array('success' => true));
				}else{
					return json_encode(array('success' => false, 'reason' => 'Unknown error', 'code' => $result->errorCode()));
				}
			}
		}
	}
?>
