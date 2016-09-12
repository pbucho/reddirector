<?php
	include_once("../includes/base.php");
	include_once("../includes/cookies.php");
	include_once("../includes/cache.php");
	include_once("../includes/roles.php");

	base_validate_login("my_urls");
	$session_token = cookies_has_session();
	$cuser = cache_get_cached_user($session_token);
	$is_admin = roles_is_admin($cuser);

?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>My URLs</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="/css/backwards.css">
		<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
		<link rel="icon" type="image/png" href="/favicon.png" sizes="32x32">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css">
	</head>
	<body>
		<?php include("../resources/top_menu.php"); ?>
		<div class="container">
			<h1>My URLs</h1>
			<?php include("../resources/addition_header.php"); ?>
			<hr/>
			<?php echo "<input type='hidden' id='is_admin' name='is_admin' value='".base_bin_2_eng($is_admin)."'>"; ?>
			<table class="table table-hover" id="link_table" style="table-layout: fixed; width: 100%; word-wrap: break-word">
				<thead>
					<tr>
						<th style="width: 10%">String</th>
						<th style="width: 50%">Long URL</th>
						<th style="width: 10%">Date added</th>
						<th style="width: 5%">Views</th>
						<th style="width: 10%">Unlisted</th>
						<th style="width: 10%">Actions</th>
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
					table = $("#link_table").DataTable( {
						"ajax": {
							"url": '/api/list.php?token='+token,
							"dataSrc": "items"
						},
						"lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
						"order": [[ 2, "desc" ]],
						"columnDefs": [
							{ "targets": 0, "data": "string" },
							{ "targets": 1,
								"data": function (row) {
									var longurl = row.longurl.startsWith("http://") || row.longurl.startsWith("https://") ? row.longurl : "http://" + row.longurl;
									return "<a href='"+longurl+"' target='_blank'>"+row.longurl+"</a>";
								}
							},
							{ "targets": 2, "data": "dateadded" },
							{ "targets": 3, "data": "views" },
							{ "targets": 4,
						 		"data": function (row){
									if(row.unlistedurl){
										return "<span style='color: green'><i class='fa fa-check'></i></span>";
									}else{
										return "<span style='color: red'><i class='fa fa-times'></i></span>";
									}
								}
							},
							{ "targets": 5,
								"data": null,
								"data": null,
								"defaultContent": "<button class='btn btn-primary' data-toggle='modal' data-target='#edit_modal'><span class='fa fa-pencil'></span></button>&nbsp;&nbsp;&nbsp;<button class='btn btn-danger' data-toggle='modal' data-target='#confirm_modal'><span class='fa fa-trash-o'></span></button>"
							}
						]
					});
					$("#link_table").on('click','button',function(){
						var data = table.row($(this).parents('tr')).data();
						setEditFields(data['string'], data['longurl'], data['unlistedurl']);
						setConfirmFields(data['string']);
					});
				});
			</script>
		</div>
		<?php
			include("../resources/footer.php");
			include("../resources/add_modal.html");
			include("../resources/edit_modal.html");
			include("../resources/confirm_modal.html");
		?>
	</body>
</html>
