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
  $admincookie = $_COOKIE['adminlogin'];  
  if ($admincookie != 'accepted')
    {
       header ('Location: ../admin37/index.php');
    };
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<meta name="generator" content="Adobe GoLive 6">
		<title>Administrator Menu</title>
		<style type="text/css" media="screen">
		<!--
.title { color: blue; font-style: normal; font-weight: bold; font-size: large; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.errormsg { color: red; font-style: normal; font-weight: bolder; font-size: small; line-height: normal; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetext { color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.style1 {font-size: medium}
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
				<td width="200" valign="top"><p class="title style1">Navigation:</p>
				  <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br>
				      <a href="menu.php">Back to Issue Menu</a></p>
			  </td>
				<td>
					<div align="left">
						<ul><li><span class="basetext"><a href="manageorders.php">Order Management</a></span>						  <li><span class="basetext"><a href="specialevents.php">Edit Special Events</a></span>
						    </li>
						  <li><span class="basetext"><a href="stampsmenu.php">Edit Stamp Information</a></span>
							<li><span class="basetext"><a href="specialitemmenu.php">Edit Special Items</a></span>
							<li><span class="basetext"><a href="bargainitemmenu.php">Edit Bargain Items</a></span>
							<li><span class="basetext"><a href="customermenu.php">Edit Customer Information</a></span>
							<li><span class="basetext"><a href="testimonialmenu.php">Add Testimonials</a></span>
							<li><span class="basetext"><a href="partsmenu.php">Edit Parts for Gifts (not stamps)</a></span>
						</ul>
				  </div>
				</td>
			</tr>
		</table>
		<p></p>
	</body>

</html>