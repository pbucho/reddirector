<?php
	include_once("conf.php");

	// this will check for token existence and validity (i.e.: not expired nor revoked)
	function tokens_validate_token($token){
		$sqlValidate = "SELECT expiry, revoked FROM tokens WHERE value = '$token'";

		$conn = conf_get_connection();
		$result = $conn->query($sqlValidate);
		$conn = null;
		$result = conf_fetch_lazy($result);

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

	function tokens_generate_token(){
		return bin2hex(openssl_random_pseudo_bytes(25));
	}

	function tokens_generate_and_persist_token($user){
		global $TOKEN_DURATION;

		$token = tokens_generate_token();
		$expiry = time() + $TOKEN_DURATION;

		$sqlUsr = "SELECT id FROM users WHERE name = '$user'";
		$conn = conf_get_connection();
		$result = $conn->query($sqlUsr);
		$userid = conf_fetch_lazy($result)['id'];
		if(is_null($userid)){
			$conn = null;
			return null;
		}

		$sqlTok = "INSERT INTO tokens (value, owner, expiry, revoked) VALUES ('$token', '$userid', FROM_UNIXTIME('$expiry'), '0')";
		$result = $conn->query($sqlTok);
		$conn = null;

		return array('token' => $token, 'expiry' => $expiry);
	}

	function tokens_revoke_token($token){
		$sqlRev = "UPDATE tokens SET revoked = '1' WHERE value = '$token'";
		$conn = conf_get_connection();
		$conn->query($sqlRev);
		$conn = null;
	}

	function tokens_revoke_all_user_tokens($user){
		$sqlUsr = "SELECT id FROM users WHERE name = '$user'";
		$conn = conf_get_connection();
		$result = $conn->query($sqlUsr);
		$userid = conf_fetch_lazy($result)['id'];
		$sqlRev = "UPDATE tokens SET revoked = '1' WHERE owner = '$userid'";
		$conn->query($sqlRev);
		$conn = null;
	}

?>
