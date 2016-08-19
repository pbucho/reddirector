<?php
	$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
	include_once($DOC_ROOT."/includes/base.php");
	include_once($DOC_ROOT."/includes/cache.php");
	include_once("func_authenticate.php");

	function api_list($token, $minlim, $maxlim){
		if(is_null($token)){
			return json_encode(array('success' => false, 'reason' => 'Missing token'));
		}

		if(!is_null($minlim) || !is_null($maxlim)){
			if(is_null($maxlim) || is_null($minlim)){
				return json_encode(array('success' => false, 'reason' => 'Missing minimum or maximum limit'));
			}
			if($minlim > $maxlim || $maxlim < 0 || $minlim < 0){
				return json_encode(array('success' => false, 'reason' => 'Invalid limits'));
			}
		}

		if(!json_decode(api_authenticate($token), true)['success']){
			return json_encode(array('success' => false, 'reason' => 'Authentication failure'));
		}

		$owner = cache_get_cached_user_id($token);
		$sqlList = "SELECT short_url, long_url, added, views, unlisted_url FROM translation WHERE owner = '$owner'";
		if(!is_null($minlim) && !is_null($maxlim)){
			$sqlList = $sqlList." LIMIT $minlim , $maxlim";
		}
		$conn = base_get_connection();
		try{
			$result = $conn->query($sqlList);
			$conn = null;
			$response_array = array('success' => true, 'items' => array());

			foreach($result as $item){
				array_push($response_array['items'], array('string' => $item['short_url'], 'longurl' => $item['long_url'], 'dateadded' => (new DateTime($item['added']))->format(DateTime::ISO8601), 'views' => (int) $item['views'], 'unlistedurl' => (bool) $item['unlisted_url']));
			}
			return json_encode($response_array);
		}catch(PDOException $e){
			$conn = null;
			return json_encode(array('success' => false, 'reason' => 'Unknown error', 'code' => $e->getCode()));
		}
	}
?>
