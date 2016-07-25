<?php
  $DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
  include_once("func_authenticate.php");
  include_once($DOC_ROOT."/includes/tokens.php");

  function api_terminate_sessions($token){
    if(is_null($token)){
      return json_encode(array('success' => false, 'reason' => 'Missing token'));
    }

    if(!json_decode(api_authenticate($token), true)['success']){
      return json_encode(array('success' => false, 'reason' => 'Authentication failure'));
    }
    
    tokens_revoke_all_but_this_token($token);
    
    return json_encode(array('success' => true));
    
  }
?>
