<?php
	include_once("../conf.php");
	include_once("../tokens.php");

	$cookie_info = has_session();

	if($cookie_info == false){
		delete_cookie("user");
		delete_cookie("token");
		header("Location: ../login.php");
	}

	if(!validate_token($cookie_info['token'])){
		delete_cookie("user");
		delete_cookie("token");
		header("Location: ../login.php");
	}

?>
<!DOCTYPE HTML>
<html lang="en">
	<!-- pbucho, 17-04-2016 -->
	<head>
		<title>Add URL</title>
		<link rel="stylesheet" href="../resources/backwards.css">
		<link rel="icon" href="data:;base64,iVBORw0KGgo=">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
			integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
			crossorigin="anonymous">
	</head>
	<body>
		<?php include("../resources/top_menu.php"); ?>
		<div class="container">
			<h1>Add URL</h1>
			<hr/>
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label class="control-label col-sm-2" for="long_url">Long URL:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="long_url" name="long_url" placeholder="Long URL" required>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="short_url">Short URL:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="long_url" name="long_url" placeholder="Short URL" required>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-primary">Shorten URL</button>
					</div>
				</div>
			</form>
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
