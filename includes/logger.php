<?php
  include_once("conf.php");

  function logger_log_action($user_id, $action, $old_value, $new_value) {
    $sqlLog = "INSERT INTO action_log (user, action, old_value, new_value) VALUES ($user_id, '$action', '$old_value', '$new_value')";
    $conn = conf_get_connection();
    $result = $conn->query($sqlLog);
    $conn = null;
  }

?>
