<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 9/20/04
******************************************************************************************/
	session_start();
	if (!array_key_exists('UName', $_SESSION)){
		header ('Location: /admin38/index.php');
	} else {
		$manageOrders=$_SESSION['canManageOrders'];
		$manageParts=$_SESSION['canManageParts'];
		$manageUsers=$_SESSION['canManageUsers'];
		$manageItems=$_SESSION['canManageItems'];
		$manageEvents=$_SESSION['canManageEvents'];
		$manageDatabase=$_SESSION['canManageDatabase'];
		$manageTestimonials=$_SESSION['canManageTestimonials'];
	};
	if ($_SESSION['canManageOrders']!="Yes"){
		header ('Location: ../menu.php');
	};
?>
<?php
	include ('../../includes/admin.inc');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<meta name="generator" content="Adobe GoLive 6">
		<title>Administrator Menu</title>
		<style type="text/css" media="screen"><!--
.title { color: blue; font-style: normal; font-weight: bold; font-size: large; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.errormsg { color: red; font-style: normal; font-weight: bolder; font-size: small; line-height: normal; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetext { color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
--></style>
	</head>

	<body bgcolor="#ffffff">
		<table width="700" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="top" width="200">
					<div align="center">
						<img src="../hdlogo.gif" alt="" height="78" width="160" border="0"></div>
				</td>
				<td valign="bottom">
					<div align="center">
						<span class="title">Administrator Menu</span></div>
				</td>
			</tr>
			<tr>
				<td width="200"></td>
				<td>
					<div align="left">
						<br>
						<br>
						<p></p>
						<ul>
							<li><span class="basetext"><a href="menuorder.php">Order &amp; Customer Management</a></span>
							<li><span class="basetext"><a href="menuevent.php">Event &amp; Testimonial Management </a></span>
							<li><span class="basetext"><a href="menuitem.php">Item &amp; Parts Management</a></span>
							<li><span class="basetext"><a href="menuissue.php">Issue Management </a></span>
							<li><span class="basetext"><a href="menudevelopment.php">Development Plans &amp; Information </a></span>
						  <li><span class="basetext"><a href="menuadmin.php">Administrator Information<br>
						  </a></span>
						</ul>
					</div>
				</td>
			</tr>
		</table>
		<p></p>
	</body>

</html>
