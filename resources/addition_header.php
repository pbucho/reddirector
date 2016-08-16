<?php
	$DOC_ROOT = $_SERVER['DOCUMENT_ROOT']."/includes";
	include_once($DOC_ROOT."/includes/conf.php");
	global $SHORT_BASE;
?>
<p>Short URLs to be used in the format <code><?php echo $SHORT_BASE; ?>/string</code></p>
<p><button class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Add URL</button>
