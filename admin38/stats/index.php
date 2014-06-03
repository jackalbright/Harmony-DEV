<?php
	include_once ('../../includes/baseSecurity.inc');

	session_start();
	if (!array_key_exists('UName', $_SESSION)){
		header ('Location: /admin38/index.php');
		exit(0);
	} else {
		$manageOrders=$_SESSION['canManageOrders'];
		$manageParts=$_SESSION['canManageParts'];
		$manageUsers=$_SESSION['canManageUsers'];
		$manageItems=$_SESSION['canManageItems'];
		$manageEvents=$_SESSION['canManageEvents'];
		$manageDatabase=$_SESSION['canManageDatabase'];
		$manageTestimonials=$_SESSION['canManageTestimonials'];
	};
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Site Statistics - Harmony Designs Inc.</title>
	<meta name="generator" content="BBEdit 7.1.4" />
	<link rel="stylesheet" href="/admin38/style/base.css" type="text/css" media="all" />
</head>
<body>
	<div id="header">
		<img src="/admin38/hdlogo.gif" alt="Harmony Designs Logo" id="logo" width="160" height="78" />
		<h1 id="title">Site Statistics</h1>
	</div>
	<div id="leftBar">
		<ul>
			<li><a href="/admin38/menu.php">Main Menu</a></li>
		</ul>
	</div>
	<div id="main">
		<ul>
			<li>
				<a href="searches.php">Searches</a>
				<br />
				Results of all searches performed on the site.
			</li>
			<li>
				Entry and Exit Pages
				<br />
				Where visitors are entering and leaving the site.
			</li>
			<li>
				Referrals
				<br />
				Where visitors came from.
			</li>
		</ul>
	</div>
</body>
</html>
