<?php
	include_once("includes/base.php");
	include_once("includes/cache.php");

	if(!isset($_GET['short'])){
		header("Location: $DEFAULT");
		die;
	}

	$short_url = $_GET['short'];
	$sqlUpd = "UPDATE translation SET views = views + 1 WHERE short_url = '$short_url'";

	$ip = $_SERVER['REMOTE_ADDR'];
	$sqlReq = "INSERT INTO requests (request, ip, ok) VALUES ('$short_url', '$ip',";

	$long_url = cache_get_cached_long_url($short_url);

	$conn = base_get_connection();
	if(is_null($long_url)){
		$sqlReq .= "'0')";
		$conn->query($sqlReq);
		$conn = null;
		$image404 = base_get_404_image();
		header("Location: $image404");
		die;
	}

	$conn->query($sqlUpd);

	$sqlReq .= "'1')";
	$conn->query($sqlReq);

	$conn = null;

	if(!base_starts_with($long_url, "http://") && !base_starts_with($long_url, "https://")){
		$long_url = "http://".$long_url;
	}
	header("Location: $long_url");

?>
