<?php
  include_once("conf.php");

  function get_cached_user($token){
    global $LOGIN_EXPIRY_S;
    $cached_username = apc_fetch("token-".$token);
    if($cached_username == false){
      $sqlRetrieveUsername = "SELECT name FROM tokens t INNER JOIN users u ON t.owner = u.id WHERE t.value = '$token'";
      $conn = getConnection();
      $result = $conn->query($sqlRetrieveUsername);
      $conn = null;

      $result = fetchLazy($result);
      if($result == false){
        return null;
      }else{
        $cached_username = $result['name'];
        apc_add("token-".$token, $cached_username, $LOGIN_EXPIRY_S);
      }
    }
    return $cached_username;
  }
?>
