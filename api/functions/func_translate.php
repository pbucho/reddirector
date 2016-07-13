<?php
	$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
	include_once($DOC_ROOT."/includes/cache.php");

	function api_translate($shorturl){
		if(is_null($shorturl)){
			return json_encode(array('success' => false, 'reason' => 'Missing short URL'));
		}

		$longurl = cache_get_cached_long_url($shorturl);
		if(is_null($longurl)){
			return json_encode(array('success' => false, 'reason' => 'Unknown short URL'));
		}else{
			return json_encode(array('success' => true, 'shorturl' => $shorturl, 'longurl' => $longurl));
		}
	}
?>
