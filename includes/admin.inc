<?php
	error_reporting (E_ALL ^ E_NOTICE);
	include ('stripMagicQuotes.inc');
	set_include_path(get_include_path() . PATH_SEPARATOR . "/usr/share/pear" . PATH_SEPARATOR . dirname(__FILE__));
	
	define("AUTH_EMAIL_USER",'orders@harmonydesigns.com');
	define("AUTH_EMAIL_PASSWORD",'!bookmark#2014');
?>
