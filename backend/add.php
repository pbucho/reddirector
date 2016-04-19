<?php
	include_once("../conf.php");

	global $SHORT_BASE;

	validate_login();

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
		<link rel="stylesheet" href="/css/bootstrap.min.css">
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
			<p style="text-align: center"><span class="backwards">&copy;</span> Pedro Bucho, <?php echo get_current_year(); ?></p>
			<script type="text/javascript" src="/js/jquery.min.js"></script>
			<script type="text/javascript" src="/js/bootstrap.min.js"></script>
		</div>
	</body>
</html>
