<?php
  include_once("base.php");

  // ACTION NAMES

  $ACTION_ADD_URL = "Add URL";
  $ACTION_MOD_URL = "Modify URL";
  $ACTION_DEL_URL = "Remove URL";

  function logger_log_action($user_id, $action, $old_value, $new_value) {
    $sqlLog = "INSERT INTO action_log (user, action, old_value, new_value) VALUES ($user_id, '$action', '$old_value', '$new_value')";
    $conn = base_get_connection();
    $result = $conn->query($sqlLog);
    $conn = null;
  }

?>
