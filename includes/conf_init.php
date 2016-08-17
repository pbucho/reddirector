<?php

	/* This is an example configuration file.
	 * Change the settings accordingly and rename the file to 'conf.php'
	 */

	// DATABASE CONFIGURATION
	
	$server = "localhost";
	$database = "redirect";
	$username = "root";
	$password = "root";
	
	// SERVICE INFORMATION

	$AUTHOR = "Pedro Bucho";
	$VERSION = "v0.3-SNAPSHOT";
	$SDATE = "2016-08-17";
	
	// SERVICE CONFIGURATION
	
	$DEFAULT = "/login.php";
	$LOGIN_EXPIRY_S = 7200;
	$TOKEN_DURATION = 86400; // 24hrs in seconds
	$EXT_IP_CHECK = "http://ip-lookup.net/index.php?ip";
	$SITE_NAME = "Reddirector";
	$SHORT_BASE = "example.com";
	
	// DEBUG - warning: setting this to true may expose server details to the public
	$DEBUG = false;

?>
