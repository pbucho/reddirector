<?php
  include_once("base.php");

  // ACTION NAMES

  $ACTION_ADD_URL = "Add URL";
  $ACTION_MOD_URL = "Modify URL";
  $ACTION_DEL_URL = "Remove URL";

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

?>
