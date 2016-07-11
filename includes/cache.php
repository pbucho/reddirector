<?php
  include_once("conf.php");

  $ONE_HOUR = 3600;

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

  function get_cached_long_url($short_url){
    global $ONE_HOUR;
    $cached_long_url = apc_fetch("url-".$short_url);
    if($cached_long_url == false){
      $sqlSelect = "SELECT long_url FROM translation WHERE short_url = '$short_url'";
      $conn = getConnection();
      $result = $conn->query($sqlSelect);
      $conn = null;

      $result = fetchLazy($result);
      if($result == false){
        return null;
      }else{
        $cached_long_url = $result['long_url'];
        apc_add("url-".$short_url, $cached_long_url, $ONE_HOUR);
      }
    }
    return $cached_long_url;
  }
?>
