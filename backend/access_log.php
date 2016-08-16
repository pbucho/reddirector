<?php
	include_once("../includes/base.php");
	include_once("../includes/cache.php");
	include_once("../includes/roles.php");

	base_validate_login("my_urls");
	$session_token = cookies_has_session();
	if(!roles_is_admin(cache_get_cached_user($session_token))){
		header("Location: /list.php");
	}
?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>Access log</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="/css/backwards.css">
		<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
		<link rel="icon" type="image/png" href="/favicon.png" sizes="32x32">
		<link rel="stylesheet" href="/resources/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
	</head>
	<body>
		<?php include("../resources/top_menu.php"); ?>
		<div class="container">
			<h1>Access log</h1>
			<hr/>
			<table class="table table-hover" id="link_table" style="table-layout: fixed; width: 100%; word-wrap: break-word">
				<thead>
					<tr>
						<th style="width: 25%">Access date</th>
						<th style="width: 50%">Requested string</th>
						<th style="width: 13%">IP address</th>
						<th style="width: 12%">Success</th>
					</tr>
				</thead>
				<tbody>
					<?php
						global $EXT_IP_CHECK;
						$sql = "SELECT * FROM requests";
						$conn = base_get_connection();
						$result = $conn->query($sql);
						$conn = null;

						$result = $result->fetchAll();

						foreach($result as $item){
							echo "<tr>";
							echo "<td>".$item['date']."</td>";
							echo "<td>".$item['request']."</td>";
							$ip = $item['ip'];
							echo "<td><a href='".$EXT_IP_CHECK."=$ip' target='_blank'>$ip</a></td>";
							echo "<td>".base_bin_2_eng($item['ok'])."</td>";
							echo "</tr>";
						}
					?>
				</tbody>
			</table>
			<script type="text/javascript" src="/js/jquery.js">
			</script>
			<script type="text/javascript" src="/resources/bootstrap/js/bootstrap.min.js"></script>
			<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js">
			</script>

			<script type="text/javascript">
				$(document).ready(function() {
					$("#link_table").dataTable( {
						"lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
						"order": [[ 0, "desc" ]]
					});
				});
			</script>
		</div>
		<?php include("../resources/footer.php"); ?>
	</body>
</html>
