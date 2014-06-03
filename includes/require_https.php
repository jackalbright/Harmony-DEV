<?
	# fix cookies to work on .harmonydesigns.com
	# fix to go to www host....
	$host = $_SERVER['SERVER_NAME'];
	$url = $_SERVER['REQUEST_URI'];
	if (!preg_match("/^\w+[.]\w+[.]\w+$/", $host)) # If just domain, ensure 'www' is there (since cert uses such)
	{
		$host = "www.$host";
	}
	#if (preg_match("/cypressinternet/", $host))
	#{
	#	$host = "pepper.he.net";
	#	$url = "/cgi-bin/suid/~tomasm$url";
	#}

	$on = true;

	if ($on && empty($_SERVER['HTTPS']) && !preg_match("/(malysoft|cypressinternet)/", $host))
	{
		#error_log("GOING TO SECURE URL=https://$host$url");
		header ("Location: https://$host$url");
		exit(0);
	}
?>
