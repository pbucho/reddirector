<?php
  $DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
  include_once($DOC_ROOT."/includes/roles.php");
  include_once($DOC_ROOT."/includes/cache.php");
  include_once("func_authenticate.php");

  function api_admin($token){
    if(is_null($token)){
      return json_encode(array('success' => false, 'reason' => 'Missing token'));
    }

    if(!json_decode(api_authenticate($token), true)['success']){
      return json_encode(array('success' => false, 'reason' => 'Authentication failure'));
    }

    return json_encode(array('success' => true, 'admin' => roles_is_admin(cache_get_cached_user($token))));
  }
?>
