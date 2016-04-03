<?php include_once("conf.php"); ?>
<!DOCTYPE HTML>
<html lang="en">
	<!-- pbucho, 03-04-2016 -->
	<head>
		<title>Redirector URL list</title>
	</head>
	<body>
		<table border="1">
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
					echo "<td><a href='".$item['long_url']."'>".$item['long_url']."</a></td>";
					echo "<td>".$item['added']."</td>";
					echo "<td>".$item['views']."</td>";
					echo "</tr>";
				}
			?>
		</table>
	</body>
</html>
