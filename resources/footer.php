<?php
	// NOTE: files that include this footer must import backwards.cds
	$DOC_ROOT = $_SERVER['DOCUMENT_ROOT']."/includes";
	include_once($DOC_ROOT."/conf.php");
	include_once($DOC_ROOT."/meta.php");
	global $VERSION, $SDATE, $AUTHOR, $SITE_NAME;
?>
<footer style="text-align: center">
	<p><span class="backwards">&copy;</span>&nbsp;
	<?php
		echo "$AUTHOR, ".conf_get_current_year();
	?></p>
	<p><small><i><?php echo "$SITE_NAME, $VERSION,&nbsp;$SDATE"; ?></i></small></p>
</footer>
