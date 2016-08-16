<?php
	$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
	include_once($DOC_ROOT."/includes/base.php");
	include_once($DOC_ROOT."/includes/cache.php");
	include_once($DOC_ROOT."/includes/logger.php");
	include_once("func_authenticate.php");

	function api_add($token, $shorturl, $longurl){
		global $ACTION_ADD_URL;
		if(is_null($shorturl)){
			return json_encode(array('success' => false, 'reason' => 'Missing short URL'));
		}

		if(is_null($longurl)){
			return json_encode(array('success' => false, 'reason' => 'Missing long URL'));
		}

		if(!is_null($token)){
			$auth = api_authenticate($token);
			if(!json_decode($auth, true)['success']){
				return json_encode(array('success' => false, 'reason' => 'Authentication failure'));
			}
		}

		if(empty($longurl) || empty($shorturl)){
			return json_encode(array('success' => false, 'reason' => 'URL not provided'));
		}else{
			$conn = base_get_connection();
			$sqlAdd = "INSERT INTO translation (short_url, long_url, owner) VALUES ('$shorturl', '$longurl', ";
			if($token != false) {
				$userid = cache_get_cached_user_id($token);
				$sqlAdd = $sqlAdd."$userid)";
			}else{
				$sqlAdd = $sqlAdd."NULL)";
			}
			try{
				$result = $conn->query($sqlAdd);
				$conn = null;
				logger_log_action($userid, $ACTION_ADD_URL, null, $shorturl." &rarr; ".$longurl);
				return json_encode(array('success' => true, 'shorturl' => $shorturl, 'longurl' => $longurl, 'owner' => cache_get_cached_user($token)));
			}catch(PDOException $e){
				$conn = null;
				if($e->getCode() == 23000){
					return json_encode(array('success' => false, 'reason' => 'String \''.$shorturl.'\' already exists'));
				}else{
					return json_encode(array('success' => false, 'reason' => 'Unknown error', 'code' => $e->getCode()));
				}
			}
		}
	}
?>
