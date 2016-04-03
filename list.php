<?php include_once("conf.php"); ?>
<!DOCTYPE HTML>
<html lang="en">
	<!-- pbucho, 03-04-2016 -->
	<head>
		<title>Redirector URL list</title>
		<link rel="icon" href="data:;base64,iVBORw0KGgo=">
		<!-- BOOTSTRAP -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
			integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
			crossorigin="anonymous">
		<!-- DATATABLES -->
		<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.css">
	</head>
	<body>
		<div class="container">
			<h1>Redirector URL list</h1>
			<p>Short URLs to be used in the format <code>r.bucho.pt/shorturl</code></p>
			<table class="table table-hover" id="link_table">
				<thead>
					<th>Short URL</th>
					<th>Long URL</th>
					<th>Date added</th>
					<th>Views</th>
				</thead>
				<?php
					$sql = "SELECT * FROM translation";
					$conn = getConnection();
					$result = $conn->query($sql);
					$conn = null;
					
					$result = $result->fetchAll();
					
					foreach($result as $item){
						echo "<tr>";
						echo "<td>".$item['short_url']."</td>";
						echo "<td><a href='".$item['long_url']."' target='_blank'>".$item['long_url']."</a></td>";
						echo "<td>".$item['added']."</td>";
						echo "<td>".$item['views']."</td>";
						echo "</tr>";
					}
				?>
			</table>
			<!-- JQUERY -->
			<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.js">
			</script>
			<!-- BOOTSTRAP -->
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
				integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
				crossorigin="anonymous">
			</script>
			<!-- DATATABLES -->
			<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.js">
			</script>
	
			<script type="text/javascript">
				$(document).ready(function() {
					$("#link_table").DataTable();
				});
			</script>
		</div>
	</body>
</html>
