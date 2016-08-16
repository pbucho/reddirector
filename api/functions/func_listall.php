<?php
	$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
	include_once($DOC_ROOT."/includes/base.php");
	include_once($DOC_ROOT."/includes/cache.php");
	include_once($DOC_ROOT."/includes/roles.php");
	include_once($DOC_ROOT."/includes/conf.php");
	include_once("func_authenticate.php");

	function api_listall($token, $minlim, $maxlim){
		if(!is_null($minlim) || !is_null($maxlim)){
			if(is_null($maxlim) || is_null($minlim)){
				return json_encode(array('success' => false, 'reason' => 'Missing minimum or maximum limit'));
			}
			if($minlim > $maxlim || $maxlim < 0 || $minlim < 0){
				return json_encode(array('success' => false, 'reason' => 'Invalid limits'));
			}
		}

		$sqlList = "SELECT short_url, long_url, added, views, u.name AS owner FROM translation t LEFT JOIN users u ON t.owner = u.id";
		if(!is_null($minlim) && !is_null($maxlim)){
			$sqlList = $sqlList." LIMIT $minlim , $maxlim";
		}
		$conn = base_get_connection();
		try{
			$result = $conn->query($sqlList);
			$conn = null;
			$response_array = array('success' => true, 'items' => array());

			foreach($result as $item){
				$item_response = array('string' => $item['short_url'], 'longurl' => $item['long_url'], 'dateadded' => (new DateTime($item['added']))->format(DateTime::ISO8601), 'views' => (int) $item['views']);
				if(!is_null($token) && json_decode(api_authenticate($token), true)['success']){
					if(roles_is_admin(cache_get_cached_user($token))){
						$item_response['owner'] = $item['owner'];
					}
				}
				array_push($response_array['items'], $item_response);
			}
			return json_encode($response_array);
		}catch(PDOException $e){
			$conn = null;
			$response_array = array('success' => false, 'reason' => 'Unknown error', 'code' => $e->getCode());
			if($DEBUG){
				array_push($response_array['message'], $e->getMessage());
			}
			return json_encode($response_array);
		}
	}
?>
