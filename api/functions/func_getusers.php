<?php
	$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
	include_once($DOC_ROOT."/includes/base.php");
	include_once($DOC_ROOT."/includes/roles.php");
	include_once($DOC_ROOT."/includes/cache.php");
	include_once("func_authenticate.php");

	function api_getusers($token){
		if(is_null($token)){
			return json_encode(array('success' => false, 'reason' => 'Missing token'));
		}

		if(!json_decode(api_authenticate($token), true)['success']){
			return json_encode(array('success' => false, 'reason' => 'Authentication failure'));
		}

		if(!roles_is_admin(cache_get_cached_user($token))){
			return json_encode(array('success' => false, 'reason' => 'Unauthorized'));
		}

		$sqlUsers = "SELECT id, name FROM users";
		$conn = base_get_connection();
		$result = $conn->query($sqlUsers);
		$conn = null;

		$return_array = array('success' => true, 'items' => array());
		foreach ($result as $user) {
			array_push($return_array['items'], array('id' => $user['id'], 'name' => $user['name']));
		}

		return json_encode($return_array);

	}
?>
