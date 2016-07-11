<?php
	include_once("includes/conf.php");
	include_once("includes/tokens.php");
	include_once("includes/cookies.php");

	$login_failed = false;
	$session_token = has_session();

	$next_page = "add";
	if(isset($_GET['next'])){
		$next_page = $_GET['next'];
	}

	if($session_token != false){
		$validToken = validate_token($session_token);

		if($validToken){
			header("Location: /backend/".$next_page.".php");
		}
	}

	if(isset($_POST['username']) && isset($_POST['password'])){
		$cuser = $_POST['username'];
		$upassword = $_POST['password'];

		$sqlPswd = "SELECT password FROM users WHERE name = '$cuser'";
		$conn = getConnection();
		$result = $conn->query($sqlPswd);
		$conn = null;
		$result = fetchLazy($result);

		$stored_pswd = $result['password'];

		if(!password_verify($upassword, $stored_pswd)){
			$login_failed = true;
		}else{
			$token_array = generate_and_persist_token($cuser);

			create_or_update_cookie("token", $token_array['token'], $token_array['expiry']);

			header("Location: /backend/".$next_page.".php");
		}
	}
?>
<!DOCTYPE HTML>
<html lang="en">
	<!-- pbucho, 08-05-2016 -->
	<head>
		<title>Redirector login</title>
		<link rel="stylesheet" href="/resources/backwards.css">
		<link href="https://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
		<link href="https://getbootstrap.com/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
		<link href="https://getbootstrap.com/examples/signin/signin.css" rel="stylesheet">

		<script src="https://getbootstrap.com/assets/js/ie-emulation-modes-warning.js"></script>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<?php include("resources/top_menu.php"); ?>
		<div class="container">
			<form class="form-signin" action="login.php<?php if(isset($_GET['next'])) echo "?next=".$_GET['next']; ?>" method="post">
				<h2>Redirector login</h2>
				<?php
					if($login_failed){
						echo "<div class='alert alert-danger'>";
						echo "Login failed. Try again.";
						echo "</div>";
					}else if(isset($_GET['logout']) && strcmp($_GET['logout'], "1") == 0){
						echo "<div class='alert alert-success'>";
						echo "You have been logged out.";
						echo "</div>";
					}
				?>
				<label for="username" class="sr-only">Username</label>
				<input type="text" id="username" name="username" class="form-control" placeholder="Username" required autofocus>
				<label for="password" class="sr-only">Password</label>
				<input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
				<input type="submit" value="Log in" class="btn btn-lg btn-primary btn-block">
			</form>
			<script src="https://getbootstrap.com/assets/js/ie10-viewport-bug-workaround.js"></script>
		</div>
		<?php include("./resources/footer.php"); ?>
	</body>
</html>
