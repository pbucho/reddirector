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
		<title>Action log</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="/css/backwards.css">
		<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
		<link rel="icon" type="image/png" href="/favicon.png" sizes="32x32">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
	</head>
	<body>
		<?php include("../resources/top_menu.php"); ?>
		<div class="container">
			<h1>Action log</h1>
			<hr/>
			<table class="table table-hover" id="link_table" style="table-layout: fixed; width: 100%; word-wrap: break-word">
				<thead>
					<tr>
						<th style="width: 10%">Timestamp</th>
						<th style="width: 10%">User</th>
						<th style="width: 10%">Action</th>
						<th style="width: 35%">Old value</th>
						<th style="width: 35%">New value</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$sqlLog = "SELECT ts, u.name AS username, anon_ip, action, old_value, new_value FROM action_log a LEFT JOIN users u ON u.id = a.user";
						$conn = base_get_connection();
						$result = $conn->query($sqlLog);
						$conn = null;

						$result = $result->fetchAll();

						foreach($result as $item){
							echo "<tr>";
							echo "<td>".$item['ts']."</td>";
							if(is_null($item['username'])){
								echo "<td>IP:".$item['anon_ip']."</td>";
							}else{
								echo "<td>".$item['username']."</td>";
							}
							echo "<td>".$item['action']."</td>";
							echo "<td>".($item['old_value'] == null ? "-" : $item['old_value'])."</td>";
							echo "<td>".($item['new_value'] == null ? "-" : $item['new_value'])."</td>";
							echo "</tr>";
						}
					?>
				</tbody>
			</table>
			<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.0.min.js">
			</script>
			<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
