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
		<title>Redirector action log</title>
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
			<h1>Redirector action log</h1>
			<hr/>
			<table class="table table-hover" id="link_table">
				<thead>
					<tr>
						<th>Timestamp</th>
						<th>User</th>
						<th>Action</th>
						<th>Old value</th>
						<th>New value</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$sqlLog = "SELECT ts, u.name AS username, action, old_value, new_value FROM action_log a INNER JOIN users u ON u.id = a.user";
						$conn = base_get_connection();
						$result = $conn->query($sqlLog);
						$conn = null;

						$result = $result->fetchAll();

						foreach($result as $item){
							echo "<tr>";
							echo "<td>".$item['ts']."</td>";
							echo "<td>".$item['username']."</td>";
							echo "<td>".$item['action']."</td>";
							//echo $item['old_value'] == null ? "NULL" : $item['old_value'];
							echo "<td>".($item['old_value'] == null ? "-" : $item['old_value'])."</td>";
							echo "<td>".($item['new_value'] == null ? "-" : $item['new_value'])."</td>";
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
