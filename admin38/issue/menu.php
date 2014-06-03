<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 9/20/04
******************************************************************************************/
	session_start();
	if (!array_key_exists('UName', $_SESSION)){
		header ('Location: ../index.php');
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
	    <link href="../../stylesheets/style.css" rel="stylesheet" type="text/css">
	    <style type="text/css">
<!--
.basetext1 {color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.style1 {font-size: medium}
-->
        </style>
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
				<td width="200" valign="top"><p class="title style1">Navigation:</p>			  
				  <p class="basetext1"><a href="../menu.php">Back to Main Menu</a></p></td>
				<td>
					<div align="left">
						<ul>
							<li><span class="basetext"><a href="newissue.php">Enter New Issue </a></span>
							<li><span class="basetext"><a href="viewopenissues.php">View &amp; Edit Open Issues </a></span>
							  <ul>
							    <li>By Date</li>
						        <li>By Assigned</li>
							    <li>By Priority</li>
								<li>By Issue</li>
							  </ul>
							<li><span class="basetext"><a href="viewallissues.php">View &amp; Edit All Issues</a></span>
							  <ul>
							    <li>By Date</li>
					            <li>By Assigned</li>
						        <li>By Priority</li>
								<li>By Issue<br>
								  <br>
								  <br>
								</li>
					          </ul>
					  </ul>
				  </div>
				</td>
			</tr>
			<tr>
			  <td></td>
			  <td>&nbsp;</td>
		  </tr>
		</table>
		<p></p>
	</body>
</html>

