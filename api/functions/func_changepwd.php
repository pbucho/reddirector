<?php
	$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
	include_once($DOC_ROOT."/includes/base.php");
	include_once($DOC_ROOT."/includes/cache.php");
	include_once($DOC_ROOT."/includes/roles.php");
	include_once($DOC_ROOT."/includes/conf.php");
	include_once("func_authenticate.php");

	function api_changepwd($token, $oldpwd, $newpwd){
		global $DEBUG;
		if(!(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')){
			return json_encode(array('success' => false, 'reason' => 'Request must be made via secure connection'));
		}
	}
?>
