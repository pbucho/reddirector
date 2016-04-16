<?php
	include_once("conf.php");
	
	$login_failed = false;
	
	if(isset($_POST['username']) && isset($_POST['password'])){
		$username = $_POST['username'];
		$upassword = $_POST['password'];
		
		$sqlPswd = "SELECT password FROM users WHERE username = '$username'";
		$conn = getConnection();
		$result = $conn->query($sqlPswd);
		$result = $result->fetch(PDO::FETCH_LAZY);
		
		$stored_pswd = $result['password'];
		
		if(!password_verify($upassword, $stored_pswd)){
			$login_failed = true;
		}
		
		$conn = null;
	}
?>
<!DOCTYPE HTML>
<html lang="en">
	<!-- pbucho, 09-04-2016 -->
	<head>
		<title>Redirector login</title>
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
		<div class="container">
			<form class="form-signin" action="login.php" method="post">
				<h2>Redirector login</h2>
				<?php
					if($login_failed){
						echo "<div class='alert alert-danger'>";
						echo "Login failed. Try again.";
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
	</body>
</html>
