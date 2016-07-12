<?php
	include_once("../includes/conf.php");
	include_once("../includes/cookies.php");
	include_once("../includes/cache.php");
	global $SHORT_BASE;

	conf_validate_login("my_urls");
	$session_token = cookies_has_session();
	$cuser = cache_get_cached_user($session_token);

	$operation_failed = false;
	$modified = false;
	$deleted = false;
	$reason = null;

	if(isset($_POST['short_url']) && isset($_POST['operation'])){
		$operation = intval($_POST['operation']);
		$short_url = $_POST['short_url'];
		$new_long_url = isset($_POST['long_url']) ? $_POST['long_url'] : null;

		if($operation != 0 && $operation != 1){
			$operation_failed = true;
			$reason = "Unknown operation";
		}else{
			// to ensure that the modification operarion is being performed by the short url
			// legitimate owner
			$sqlValidateUrl = "SELECT t.short_url FROM tokens tk INNER JOIN translation t ON tk.owner = t.owner WHERE tk.value = '$session_token' AND t.short_url = '$short_url'";
			$conn = conf_get_connection();
			$result = $conn->query($sqlValidateUrl);
			$result = conf_fetch_lazy($result);

			if($result == false){
				$operation_failed = true;
				$reason = "Invalid short URL";
			}else{
				if($operation == 1){
					if(is_null($new_long_url)){
						$operation_failed = true;
						$reason = "Missing long URL";
					}else{
						$sqlUrl = "UPDATE translation SET long_url = '$new_long_url' WHERE short_url = '$short_url'";
					}
				}else if($operation == 0){
					$sqlUrl = "DELETE FROM translation WHERE short_url = '$short_url'";
				}
				try{
					$result = $conn->query($sqlUrl);
					$modified = $operation == 1 ? true : false;
					$deleted = $operation == 0 ? true : false;
				}catch(PDOException $e){
					$operation_failed = true;
					$reason = "An error occurred (code: ".$e->getCode().")";
					if($DEBUG){
						$reason = $reason." ".$e->getMessage();
					}
				}
			}
			$conn = null;
		}
	}

?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>My URLs</title>
		<link rel="stylesheet" href="/css/backwards.css">
		<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
		<link rel="icon" type="image/png" href="/favicon.png" sizes="32x32">
		<link rel="stylesheet" href="/resources/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.css">
		<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
	</head>
	<body>
		<?php include("../resources/top_menu.php"); ?>
		<div class="container">
			<h1>My URLs</h1>
			<p>Short URLs to be used in the format <code><?php echo $SHORT_BASE; ?>/string</code></p>
			<hr/>
			<?php
				if($operation_failed){
					echo "<div class='alert alert-danger'>";
					echo "Could not modify or delete URL: ".$reason;
					echo "</div>";
				}else if($modified){
					echo "<div class='alert alert-success'>";
					echo "URL modified successfully";
					echo "</div>";
				}else if($deleted){
					echo "<div class='alert alert-success'>";
					echo "URL deleted successfully";
					echo "</div>";
				}
			?>
			<table class="table table-hover" id="link_table">
				<thead>
					<tr>
						<th>String</th>
						<th>Long URL</th>
						<th>Date added</th>
						<th>Views</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
						//$sqlURL = "SELECT short_url, long_url, added, views FROM translation t INNER JOIN users u ON t.owner = u.id WHERE u.name = '$cuser'";
						$sqlURL = "SELECT short_url, long_url, t.added AS added, views FROM translation t INNER JOIN tokens tk ON t.owner = tk.owner WHERE tk.value = '$session_token'";
						$conn = conf_get_connection();
						$result = $conn->query($sqlURL);
						$conn = null;

						$result = $result->fetchAll();

						foreach($result as $item){
							$long_url_item = conf_starts_with($item['long_url'], "http://") || conf_starts_with($item['long_url'], "https://") ? $item['long_url'] : "http://".$item['long_url'];
							echo "<tr>";
							echo "<td>".$item['short_url']."</td>";
							echo "<td><a href='$long_url_item' target='_blank'>".$item['long_url']."</a></td>";
							echo "<td>".$item['added']."</td>";
							echo "<td>".$item['views']."</td>";
							echo "<td style='text-align: center'>";
							echo "<button class='btn btn-primary' data-toggle='modal' data-target='#edit_modal' onclick=\"setEditFields('".$item['long_url']."','".$item['short_url']."')\"><span class='fa fa-pencil'></span></button>&nbsp;&nbsp;&nbsp;";
							echo "<button class='btn btn-danger' data-toggle='modal' data-target='#confirm_modal' onclick=\"setConfirmFields('".$item['short_url']."')\"><span class='fa fa-trash-o'></span></button>";
							echo "</td>";
							echo "</tr>";
						}
					?>
				</tbody>
			</table>
			<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.js">
			</script>
			<script type="text/javascript" src="/resources/bootstrap/js/bootstrap.min.js">
			</script>
			<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.js">
			</script>

			<script type="text/javascript">
				$(document).ready(function() {
					$("#link_table").dataTable( {
						"lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
						"order": [[ 2, "desc" ]]
					});
				});
			</script>
			<script type="text/javascript">
				function setEditFields(long_url, short_url) {
					$("#ed_long_url").val(long_url);
					$("#ed_short_url").val(short_url);
					$("#ed_short_url_disabled").val(short_url);
				}
				function setConfirmFields(short_url) {
					$("#conf_short_url").val(short_url);
					$("#conf_show_url").html(short_url);
				}
			</script>
		</div>
		<?php include("../resources/footer.php"); ?>
		<?php
			include("../resources/edit_modal.html");
			include("../resources/confirm_modal.html");
		?>
	</body>
</html>
