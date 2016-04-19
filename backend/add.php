<?php
	include_once("../conf.php");
	include_once("../tokens.php");

	global $SHORT_BASE;

	$cookie_info = has_session();

	if($cookie_info == false){
		delete_cookie("user");
		delete_cookie("token");
		header("Location: /login.php");
	}

	if(!validate_token($cookie_info['token'])){
		delete_cookie("user");
		delete_cookie("token");
		header("Location: /login.php");
	}

	$operation_failed = false;
	$shortened = false;
	$reason = null;

	if(isset($_POST['long_url']) && isset($_POST['short_url'])){
		$long_url = $_POST['long_url'];
		$short_url = $_POST['short_url'];

		if(empty($long_url) || empty($short_url)){
			$operation_failed = true;
			$reason = "URL not provided";
		}else{
			$sqlAdd = "INSERT INTO translation (short_url, long_url) VALUES ('$short_url', '$long_url')";
			$conn = getConnection();
			try{
				$result = $conn->query($sqlAdd);
				$shortened = true;
			}catch(PDOException $e){
				$operation_failed = true;
				if($e->getCode() == 23000){
					$reason = "String '$short_url' already exists.";
				}else{
					$reason = "Unknown error.";
				}
			}
			$conn = null;
		}
	}

?>
<!DOCTYPE HTML>
<html lang="en">
	<!-- pbucho, 18-04-2016 -->
	<head>
		<title>Add URL</title>
		<link rel="stylesheet" href="/resources/backwards.css">
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
			<?php
				if($operation_failed){
					echo "<div class='alert alert-danger'>";
					echo "Could not shorten URL: ".$reason;
					echo "</div>";
				}
				if($shortened){
					echo "<div class='alert alert-success'>";
					echo "URL shortened successfully: <code>$SHORT_BASE/$short_url</code>";
					echo "</div>";
				}
			?>
			<form class="form-horizontal" role="form" action="add.php" method="post">
				<div class="form-group">
					<label class="control-label col-sm-2" for="long_url">Long URL:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="long_url" name="long_url" placeholder="Long URL"
						<?php
							if($operation_failed){
								echo "value='$long_url'";
							}
						?>
						required>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="short_url">String:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="short_url" name="short_url" placeholder="String"
						<?php
							if($operation_failed){
								echo "value='$short_url'";
							}
						?>
						required>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-primary">Shorten URL</button>
					</div>
				</div>
			</form>
			<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.js">
			</script>
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
				integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
				crossorigin="anonymous">
			</script>
		</div>
		<?php include("../resources/footer.php"); ?>
	</body>
</html>
