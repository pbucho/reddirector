<?php
	// NOTE: files that include this footer must import backwards.cds
	include_once($_SERVER['DOCUMENT_ROOT']."/conf.php");
	
?>
<footer style="text-align: center">
	<p><span class="backwards">&copy;</span>&nbsp;
	<?php
		echo get_author().", ".get_current_year();
	?></p>
	<p><small><i>redirector, <?php echo get_software_version().",&nbsp;".get_software_date(); ?></i></small></p>
</footer>
