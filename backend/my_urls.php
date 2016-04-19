<?php
	include_once("../conf.php");
	include_once("../cookies.php");

	validate_login();
	
	$cuser = has_session()['user'];

?>
<!DOCTYPE HTML>
<html lang="en">
	<!-- pbucho, 19-04-2016 -->
	<head>
		<title>My URLs</title>
		<link rel="stylesheet" href="/css/backwards.css">
		<link rel="stylesheet" href="/css/bootstrap.min.css">
	</head>
	<body>
		<?php include("../resources/top_menu.php"); ?>
		<div class="container">
			<h1>My URLs</h1>
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
						$sqlURL = "SELECT short_url, long_url, added, views FROM translation t INNER JOIN users u ON t.owner = u.id WHERE u.name = '$cuser'";
						$conn = getConnection();
						$result = $conn->query($sqlURL);
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
				</tbody>
			</table>
			<p style="text-align: center"><span class="backwards">&copy;</span> Pedro Bucho, <?php echo get_current_year(); ?></p>
			<script type="text/javascript" src="/js/jquery.min.js"></script>
			<script type="text/javascript" src="/js/bootstrap.min.js"></script>
		</div>
	</body>
</html>
