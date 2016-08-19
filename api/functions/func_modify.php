<?php
	$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
	include_once($DOC_ROOT."/includes/base.php");
	include_once($DOC_ROOT."/includes/roles.php");
	include_once($DOC_ROOT."/includes/cache.php");
	include_once($DOC_ROOT."/includes/logger.php");
	include_once("func_authenticate.php");

	function api_modify($token, $shorturl, $newlongurl, $unlistedurl){
		global $ACTION_MOD_URL;
		$unlistedurl = base_eng_2_int($unlistedurl);
		if(is_null($token)){
			return json_encode(array('success' => false, 'reason' => 'Missing token'));
		}

		if(is_null($shorturl)){
			return json_encode(array('success' => false, 'reason' => 'Missing short URL'));
		}

		if(is_null($newlongurl)){
			return json_encode(array('success' => false, 'reason' => 'Missing new long URL'));
		}

		if(!json_decode(api_authenticate($token), true)['success']){
			return json_encode(array('success' => false, 'reason' => 'Authentication failure'));
		}

		$conn = base_get_connection();
		$sqlValidate1 = "SELECT short_url, long_url, unlisted_url FROM translation WHERE short_url = '$shorturl'";
		$result = $conn->query($sqlValidate1);
		$result = base_fetch_lazy($result);

		if($result == false){
			$conn = null;
			return json_encode(array('success' => false, 'reason' => 'Unknown short URL'));
		}

		$sqlModify = "UPDATE translation SET long_url = '$newlongurl', unlisted_url = '$unlistedurl' WHERE short_url = '$shorturl'";
		$userid = cache_get_cached_user_id($token);
		$oldlongurl = $result['long_url'];
		$oldvalue = $shorturl." &rarr; ".$oldlongurl;
		if($result['unlisted_url'] == 1){
			$oldvalue .= " (unlisted)";
		}
		$newvalue = $shorturl." &rarr; ".$newlongurl;
		if($unlistedurl == 1){
			$newvalue .= " (unlisted)";
		}
		if(roles_is_admin(cache_get_cached_user($token))){
			$result = $conn->query($sqlModify);
			$conn = null;
			logger_log_action($userid, $ACTION_MOD_URL, $oldvalue, $newvalue);
			return json_encode(array('success' => true));
		}else{
			$sqlValidate2 = "SELECT t.short_url FROM tokens tk INNER JOIN translation t ON tk.owner = t.owner WHERE tk.value = '$token' AND t.short_url = '$shorturl'";
			$result = $conn->query($sqlValidate2);
			$result = base_fetch_lazy($result);
			if($result == false){
				$conn = null;
				return json_encode(array('success' => false, 'reason' => 'Operation not allowed'));
			}else{
				$result = $conn->query($sqlModify);
				$conn = null;
				if($result->rowCount() == 1){
					logger_log_action($userid, $ACTION_MOD_URL, $shorturl." &rarr; ".$oldlongurl, $shorturl." &rarr; ".$newlongurl);
					return json_encode(array('success' => true));
				}else{
					return json_encode(array('success' => false, 'reason' => 'Unknown error', 'code' => $result->errorCode()));
				}
			}
		}
	}
?>
