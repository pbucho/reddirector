<?php
	include_once("includes/conf.php");
	include_once("includes/meta.php");
	include_once("includes/cookies.php");
	include_once("includes/cache.php");
	include_once("includes/roles.php");
	global $SHORT_BASE;

	$session_token = cookies_has_session();
	$is_admin = roles_is_admin(cache_get_cached_user($session_token));

?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>Redirector URL list</title>
		<link rel="stylesheet" href="/css/backwards.css">
		<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
		<link rel="icon" type="image/png" href="/favicon.png" sizes="32x32">
		<link rel="stylesheet" href="/resources/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.css">
		<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
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
						<?php
							if($is_admin){
								echo "<th>Owner</th>";
								echo "<th>Admin actions</th>";
							}
						?>
					</tr>
				</thead>
				<tbody>
					<?php
						/*$sql = "SELECT short_url, long_url, added, views, u.name AS owner FROM translation t LEFT JOIN users u ON t.owner = u.id";
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
							if($is_admin){
								echo "<td>".(is_null($item['owner']) ? "-" : $item['owner'])."</td>";
								echo "<td style='text-align: center'>";
								echo "<button class='btn btn-primary' data-toggle='modal' data-target='#edit_modal' onclick=\"setEditFields('".$item['long_url']."','".$item['short_url']."')\"><span class='fa fa-pencil'></span></button>&nbsp;&nbsp;&nbsp;";
								echo "<button class='btn btn-danger' data-toggle='modal' data-target='#confirm_modal' onclick=\"setConfirmFields('".$item['short_url']."')\"><span class='fa fa-trash-o'></span></button>";
								echo "</td>";
							}
							echo "</tr>";
						}*/
					?>
				</tbody>
			</table>
			<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.js">
			</script>
			<script type="text/javascript" src="/resources/bootstrap/js/bootstrap.min.js">
			</script>
			<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.js">
			</script>
			<script type="text/javascript" src="/js/api_com.js"></script>
			<script type="text/javascript">
				var token = getToken();
				$(document).ready(function() {
					$("#link_table").DataTable( {
						"ajax": {
							"url": token == null ? '/api/listall.php' : '/api/listall.php?token='+token,
							//"url": '/api/listall.php?token='+token,
							"dataSrc": "items"
						},
						"lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
						"order": [[ 2, "desc" ]],
						"columns": [
							{ data: "string" },
							{ data: "longurl" },
							{ data: "dateadded" },
							{ data: "views" },
							{ data: "owner" }
						],
						"columnDefs": [ {
							"targets": this.columns().header().length - 1,
							"data": null,
							"defaultContent": "<button class='btn btn-primary' data-toggle='modal' data-target='#edit_modal' onclick=\"setEditFields()\"><span class='fa fa-pencil'></span></button>&nbsp;&nbsp;&nbsp;<button class='btn btn-danger' data-toggle='modal' data-target='#confirm_modal' onclick=\"setConfirmFields()\"><span class='fa fa-trash-o'></span></button>"
						}]
					});
				});
			</script>
			<script type="text/javascript">
				function setEditFields(long_url, short_url) {
					$("#ed_long_url").val(long_url);
					$("#ed_short_url").val(short_url);
					$("#ed_short_url_disabled").val(short_url);
				}
				function setConfirmFields(short_url) {
					$("#conf_short_url").val(short_url);
					$("#conf_show_url").html(short_url);
				}
			</script>
		</div>
		<?php include("./resources/footer.php"); ?>
		<?php
			include("./resources/edit_modal.html");
			include("./resources/confirm_modal.html");
		?>
	</body>
</html>
