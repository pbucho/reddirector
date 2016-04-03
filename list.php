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
	</head>
	<body>
		<div class="container">
			<h1>Redirector URL list</h1>
			<p>Short URLs to be used in the format <code>r.bucho.pt/shorturl</code></p>
			<table class="table table-hover">
				<tr>
					<th>Short URL</th>
					<th>Long URL</th>
					<th>Date added</th>
					<th>Views</th>
				</tr>
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
			<!-- BOOTSTRAP -->
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
				integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
				crossorigin="anonymous">
			</script>
		</div>
	</body>
</html>
