<?php
	// NOTE: files that include this footer must import backwards.cds
	include_once("../conf.php");
	
?>
<footer>
	<p><span class="backwards">&copy;</span>&nbsp;
	<?php
		echo getAuthor().", ".getCurrentYear();
	?></p>
	<p><small>redirector, <?php echo getSoftwareVersion(); ?></small></p>
</footer>
