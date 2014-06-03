<?php
	include_once ("../includes/config.inc");
	$oldIncludePath = get_include_path();
	$newIncludePath = $config['admin']['fileBase'] . ':' . $oldIncludePath;
	set_include_path($newIncludePath);
	error_reporting(E_ALL);
	include_once ("includes/baseSecurity.inc");
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

	include_once ('includes/database.inc');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>MYOB Import - Harmony Designs Inc.</title>
	<meta name="generator" content="BBEdit 7.1.4" />
	<link rel="stylesheet" href="/admin38/style/base.css" type="text/css" media="all" />
	<link rel="alternate stylesheet" href="/admin38/style/print.css" type="text/css" media="all" title="print" />
</head>
<body>
	<div id="header">
		<img src="/admin38/hdlogo.gif" alt="Harmony Designs Logo" id="logo" width="160" height="78" />
		<h1 id="title">MYOB Import</h1>
	</div>
	<div id="leftBar">
		<h4>Navigation</h4>
		<ul>
			<li><a href="../menu.php">Main Menu</a></li>
		</ul>
	</div>
	<div id="main">
		<p><?php echo get_include_path(); ?></p>
	</div>
</body>
</html>
<?php
	set_include_path($oldIncludePath);
?>
