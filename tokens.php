<?php
	include_once("conf.php");

	$TOKEN_DURATION = 15552000; // 6 months in seconds

	// TODO update to validate with username
	function validate_token($token){
		$sqlValidate = "SELECT expiry, revoked FROM tokens WHERE value = '$token'";

		$conn = getConnection();
		$result = $conn->query($sqlValidate);
		$conn = null;
		$result = $result->fetch(PDO::FETCH_LAZY);

		if($result == false){
			return false;
		}

		if(strcmp($result['revoked'], "1") === 0){
			return false;
		}

		$expiry = new DateTime($result['expiry'], new DateTimeZone("UTC"));
		$expiry = $expiry->getTimestamp();
		$now = time();

		if($expiry - $now > 0){
			return true;
		}else{
			return false;
		}
	}

	function generate_token($user){
		return bin2hex(openssl_random_pseudo_bytes(25));
	}

	function generate_and_persist_token($user){
		global $TOKEN_DURATION;

		$token = generate_token($user);
		$expiry = time() + $TOKEN_DURATION;

		$sqlUsr = "SELECT id FROM users WHERE name = '$user'";
		$conn = getConnection();
		$result = $conn->query($sqlUsr);
		$userid = fetchLazy($result)['id'];
		if($userid == null){
			$conn = null;
			return null;
		}

		$sqlTok = "INSERT INTO tokens (value, owner, expiry, revoked) VALUES ('$token', '$userid', FROM_UNIXTIME('$expiry'), '0')";
		$result = $conn->query($sqlTok);
		$conn = null;

		return array('token' => $token, 'expiry' => $expiry);
	}

	function revoke_token($token){
		$sqlRev = "UPDATE tokens SET revoked = '1' WHERE value = '$token'";
		$conn = getConnection();
		$conn->query($sqlRev);
		$conn = null;
	}

	function revoke_all_user_tokens($user){
		$sqlUsr = "SELECT id FROM users WHERE name = '$user'";
		$conn = getConnection();
		$result = $conn->query($sqlUsr);
		$userid = fetchLazy($result)['id'];
		$sqlRev = "UPDATE tokens SET revoked = '1' WHERE owner = '$userid'";
		$conn->query($sqlRev);
		$conn = null;
	}

?>
