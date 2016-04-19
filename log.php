<?php include_once("conf.php"); ?>
<!DOCTYPE HTML>
<html lang="en">
	<!-- pbucho, 16-04-2016 -->
	<head>
		<title>Redirector access log</title>
		<link rel="stylesheet" href="/resources/backwards.css">
		<link rel="icon" href="data:;base64,iVBORw0KGgo=">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
			integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
			crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.css">
	</head>
	<body>
		<?php include("resources/top_menu.php"); ?>
		<div class="container">
			<h1>Redirector access log</h1>
			<hr/>
			<table class="table table-hover" id="link_table">
				<thead>
					<tr>
						<th>Access date</th>
						<th>Requested string</th>
						<th>IP address</th>
						<th>Success</th>
					</tr>
				</thead>
				<tbody>
					<?php
						global $EXT_IP_CHECK;
						$sql = "SELECT * FROM requests";
						$conn = getConnection();
						$result = $conn->query($sql);
						$conn = null;

						$result = $result->fetchAll();

						foreach($result as $item){
							echo "<tr>";
							echo "<td>".$item['date']."</td>";
							echo "<td>".$item['request']."</td>";
							$ip = $item['ip'];
							echo "<td><a href='".$EXT_IP_CHECK."=$ip' target='_blank'>$ip</a></td>";
							echo "<td>".binaryToEnglish($item['ok'])."</td>";
							echo "</tr>";
						}
					?>
				</tbody>
			</table>
			<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.js">
			</script>
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
				integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
				crossorigin="anonymous">
			</script>
			<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.js">
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
		<?php include("./resources/footer.php"); ?>
	</body>
</html>
