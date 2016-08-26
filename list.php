<?php
	include_once("includes/base.php");
	include_once("includes/cookies.php");
	include_once("includes/cache.php");
	include_once("includes/roles.php");

	$session_token = cookies_has_session();
	$is_admin = roles_is_admin(cache_get_cached_user($session_token));

?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>URL list</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="/css/backwards.css">
		<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
		<link rel="icon" type="image/png" href="/favicon.png" sizes="32x32">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css">
	</head>
	<body>
		<?php include("resources/top_menu.php"); ?>
		<div class="container">
			<h1>URL list</h1>
			<?php include("resources/addition_header.php"); ?>
			<hr/>
			<?php echo "<input type='hidden' id='is_admin' name='is_admin' value='".base_bin_2_eng($is_admin)."'>"; ?>
			<table class="table table-hover" id="link_table" style="table-layout: fixed; width: 100%; word-wrap: break-word">
				<thead>
					<tr>
						<th style="width: 10%">String</th>
						<th style="width: 50%">Long URL</th>
						<th style="width: 10%">Date added</th>
						<th style="width: 5%">Views</th>
						<?php
							if($is_admin){
								echo "<th style=\"width: 7.5%\">Owner</th>";
								echo "<th style=\"width: 7.5%\">Unlisted</th>";
								echo "<th style=\"width: 10%\">Admin actions</th>";
							}
						?>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
			<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.0.min.js">
			</script>
			<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
			</script>
			<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js">
			</script>
			<script type="text/javascript" src="/js/api_com.js"></script>
			<script type="text/javascript">
				var token = getToken();
				var table;
				$(document).ready(function(){
					if(!isAdmin()){
						table = $("#link_table").DataTable( {
							"ajax": {
								"url": token == null ? '/api/listall.php' : '/api/listall.php?token='+token,
								"dataSrc": "items"
							},
							"lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
							"order": [[ 2, "desc" ]],
							"columns": [
								{ data: "string" },
								{ data: "longurl" },
								{ data: "dateadded" },
								{ data: "views" }
							]
						});
					}else{
						table = $("#link_table").DataTable({
							"ajax": {
								"url": '/api/listall.php?token='+token,
								"dataSrc": "items"
							},
							"lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
							"order": [[ 2, "desc" ]],
							"columnDefs": [
								{ "targets": 0, "data": "string" },
								{ "targets": 1, "data": "longurl" },
								{ "targets": 2, "data": "dateadded" },
								{ "targets": 3, "data": "views" },
								{ "targets": 4, "data": "owner" },
								{ "targets": 5,
									"data": function (row){
										if(row.unlistedurl){
											return "<span style='color: green'><i class='fa fa-check'></i></span>";
										}else{
											return "<span style='color: red'><i class='fa fa-times'></i></span>";
										}
									}
								},
								{ "targets": 6,
									"data": null,
									"defaultContent": "<button class='btn btn-primary' data-toggle='modal' data-target='#edit_modal'><span class='fa fa-pencil'></span></button>&nbsp;&nbsp;&nbsp;<button class='btn btn-danger' data-toggle='modal' data-target='#confirm_modal'><span class='fa fa-trash-o'></span></button>"
								}
							]
						});
					}
					$("#link_table").on('click','button',function(){
						var data = table.row($(this).parents('tr')).data();
						setEditFields(data['string'], data['longurl'], data['unlistedurl']);
						setConfirmFields(data['string']);
					});
				});
			</script>
		</div>
		<?php
			include("resources/footer.php");
			include("resources/add_modal.html");
			include("resources/edit_modal.html");
			include("resources/confirm_modal.html");
		?>
	</body>
</html>
