<?php
	include_once("../conf.php");
	include_onec("../cookies.php");

	validate_login();
	
	$cuser = has_session()['user'];

?>
<!DOCTYPE HTML>
<html lang="en">
	<!-- pbucho, 19-04-2016 -->
	<head>
		<title>My URLs</title>
		<link rel="stylesheet" href="/resources/backwards.css">
		<link rel="icon" href="data:;base64,iVBORw0KGgo=">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
			integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
			crossorigin="anonymous">
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
						// TODO finish
					?>
				</tbody>
			</table>
			<p style="text-align: center"><span class="backwards">&copy;</span> Pedro Bucho, <?php echo get_current_year(); ?></p>
			<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.js">
			</script>
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
				integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
				crossorigin="anonymous">
			</script>
		</div>
	</body>
</html>
