<?php
  include_once("base.php");
  include_once("cache.php");

  // ACTION NAMES

  $ACTION_ADD_URL = "Add URL";
  $ACTION_MOD_URL = "Modify URL";
  $ACTION_DEL_URL = "Remove URL";
  $ACTION_USR_LOGIN = "User login";

  function logger_log_action($user_id, $action, $old_value, $new_value) {
    $sqlLog = "INSERT INTO action_log (user, anon_ip, action, old_value, new_value) VALUES (";
    if(is_null($user_id)){
		$sqlLog .= "NULL, '".$_SERVER['REMOTE_ADDR']."', ";
	}else{
		$sqlLog .= "$user_id, NULL, ";
	}
	$sqlLog .= "'$action', '$old_value', '$new_value')";
    $conn = base_get_connection();
    $result = $conn->query($sqlLog);
    $conn = null;
  }

  function logger_log_user_login($token) {
    global $ACTION_USR_LOGIN;
    $currentip = $_SERVER['REMOTE_ADDR'];
    $user_id = cache_get_cached_user_id($token);
    $sqlLog = "UPDATE users SET last_login = NOW(), last_ip = '$currentip' WHERE id = $user_id";

    $conn = base_get_connection();
    $result = $conn->query($sqlLog);
    $conn = null;
    logger_log_action($user_id, $ACTION_USR_LOGIN, null, cache_get_cached_user($token).", IP:$currentip");
  }

?>
