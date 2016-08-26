<?php
	include_once("../includes/base.php");
	include_once("../includes/cookies.php");
	include_once("../includes/cache.php");
	include_once("../includes/tokens.php");

	base_validate_login("control_panel");
	$session_token = cookies_has_session();
	$cuser = cache_get_cached_user($session_token);
	$user_id = cache_get_cached_user_id($session_token);
	$active_sessions = tokens_get_active_sessions($cuser);
?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>Control panel</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="/css/backwards.css">
		<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
		<link rel="icon" type="image/png" href="/favicon.png" sizes="32x32">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css">
	</head>
	<body>
		<?php include("../resources/top_menu.php"); ?>
		<div class="container">
			<h1>Control panel</h1>
			<hr/>
			<br/>
			<div class="col-sm-6">
				<h2>Personal details</h2>
				<table class="table">
					<tr>
						<td class="col-sm-2"><b>User name</b></td><td class="col-sm-10"><?php echo $cuser; ?></td>
					</tr>
					<tr>
						<td class="col-sm-2"><b>Registered</b></td><td class="col-sm-10">
						<?php
							$sqlDate = "SELECT registered FROM users WHERE name = '$cuser'";
							$conn = base_get_connection();
							$result = $conn->query($sqlDate);
							$conn = null;
							$result = base_fetch_lazy($result);
							echo $result['registered'];
						?>
						</td>
					</tr>
					<tr>
						<td class="col-sm-2"><b>Current IP</b></td><td class="col-sm-10">
						<?php
							echo $_SERVER['REMOTE_ADDR'];
						?>
						</td>
					</tr>
					<tr>
						<td class="col-sm-2"><b>Roles</b></td><td class="col-sm-10"><b><kbd>
						<?php
							$role_print = roles_is_admin($cuser) ? "admin" : "none";
							echo $role_print;
						?>
						</kbd></b></td>
					</tr>
				</table>
			</div>
			<div class="col-sm-6">
				<h2>Password (NYI)</h2>
				<form class="form-horizontal" role="form">
					<table class="table">
						<tr>
							<td class="col-sm-4"><b>Old password</b></td><td class="col-sm-8">
								<div class="form-group"><abbr title="This feature is not yet implemented"><input type="password" class="form-control" id="old_password" name="old_password" disabled></abbr></div>
							</td>
						</tr>
						<tr>
							<td class="col-sm-4"><b>New password</b></td><td class="col-sm-8">
								<div class="form-group"><abbr title="This feature is not yet implemented"><input type="password" class="form-control" id="new_password" name="new_password" disabled></abbr></div>
							</td>
						</tr>
						<tr>
							<td class="col-sm-4"><b>Confirm new password</b></td><td class="col-sm-8">
								<div class="form-group"><abbr title="This feature is not yet implemented"><input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" disabled></abbr></div>
							</td>
						</tr>
					</table>
					<abbr title="This feature is not yet implemented"><input type="submit" class="btn btn-primary" value="Change password" disabled="true"></abbr>
				</form>
			</div>
			<br/>
			<h2>Login management</h2>
			You have <?php echo $active_sessions; ?> active session<?php echo ($active_sessions == 1 ? "" : "s"); ?>.
			<br/><br/>
			<button class="btn btn-primary" onclick="terminateOtherSessions()">Terminate all other sessions</button>
			&nbsp;&nbsp;<i id="spinner" class="fa fa-circle-o-notch fa-spin"></i>
			<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
			<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
			<script type="text/javascript" src="/js/api_com.js"></script>
			<script type="text/javascript">
				$(document).ready(function() {
					$("#spinner").hide();
				});
				var token = getToken();
				function terminateOtherSessions() {
					var req = new XMLHttpRequest();
					var connection = "/api/terminatesessions.php?token="+token;
					req.open("GET", connection, true);
					req.onreadystatechange = function(){
						if(req.readyState == 4 && req.status == 200){
							var response = req.responseText;
							response = JSON.parse(response);
							if(response['success']){
								location.reload();
							}else{
								alert("Could not terminate sessions: "+response['reason']);
							}
						}
					};
					req.send();
				}
			</script>
		</div>
		<?php
			include("../resources/footer.php");
		?>
	</body>
</html>
