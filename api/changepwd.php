<?php
	include_once("functions/func_changepwd.php");

	$NO_WARN = true;
	echo api_changepwd(isset($_POST['token']) ? $_POST['token'] : null,
										 isset($_POST['oldpwd']) ? $_POST['oldpwd'] : null,
										 isset($_POST['newpwd']) ? $_POST['newpwd'] : null);

?>
