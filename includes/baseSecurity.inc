<?php
	if ( strpos($_SERVER['SERVER_NAME'], 'hdtest.com') !== false && !array_key_exists ( 'allowAccess', $_COOKIE ) ) {
		#$redirect = 'Location: http://' . $_SERVER['SERVER_NAME'] . '/login.php?referer=' . $_SERVER['SCRIPT_NAME'];
		#header ($redirect);
		#echo 'You are not authorized to access this server';
		#exit (0);
	}
?>
