<?php
	include_once("includes/conf.php");
	include_once("includes/meta.php");
	global $SHORT_BASE;
?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>Redirector URL list</title>
		<link rel="stylesheet" href="/css/backwards.css">
		<link rel="icon" href="data:;base64,iVBORw0KGgo=">
		<link rel="stylesheet" href="/resources/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.css">
	</head>
	<body>
		<?php include("resources/top_menu.php"); ?>
		<div class="container">
			<h1>Redirector URL list</h1>
			<p>Short URLs to be used in the format <code><?php echo $SHORT_BASE; ?>/string</code></p>
			<hr/>
			<table class="table table-hover" id="link_table">
				<thead>
					<tr>
						<th>String</th>
						<th>Long URL</th>
						<th>Date added</th>
						<th>Views</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$sql = "SELECT * FROM translation";
						$conn = conf_get_connection();
						$result = $conn->query($sql);
						$conn = null;

						$result = $result->fetchAll();

						foreach($result as $item){
							$long_url_item = conf_starts_with($item['long_url'], "http://") || conf_starts_with($item['long_url'], "https://") ? $item['long_url'] : "http://".$item['long_url'];
							echo "<tr>";
							echo "<td>".$item['short_url']."</td>";
							echo "<td><a href='$long_url_item' target='_blank'>".$item['long_url']."</a></td>";
							echo "<td>".$item['added']."</td>";
							echo "<td>".$item['views']."</td>";
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
		</div>
		<?php include("./resources/footer.php"); ?>
	</body>
</html>
