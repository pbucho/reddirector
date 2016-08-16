<?php

	// DATABASE CONFIGURATION
	
	$server = "localhost";
	$database = "redirect";
	$username = "root";
	$password = "SM901n";
	
	// SERVICE INFORMATION

	$AUTHOR = "Pedro Bucho";
	$VERSION = "v0.3-SNAPSHOT";
	$SDATE = "2016-08-16";
	
	// SERVICE CONFIGURATION
	
	$DEFAULT = "/login.php";
	$LOGIN_EXPIRY_S = 7200;
	$TOKEN_DURATION = 86400; // 24hrs in seconds
	$EXT_IP_CHECK = "http://ip-lookup.net/index.php?ip";
	$SITE_NAME = "Reddirector";
	$SHORT_BASE = "bucho.pt";
	
	// DEBUG - warning: setting this to true may expose server details to the public
	$DEBUG = true;

?>
