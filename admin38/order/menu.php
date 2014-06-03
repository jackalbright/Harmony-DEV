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
		<title>Order Management Menu</title>
	    <link href="../../stylesheets/style.css" rel="stylesheet" type="text/css">
	    <style type="text/css">
<!--
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
						<span class="title">Order Management Menu</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top"><p class="title style1 style1">Navigation:</p>
			    <p class="basetext1"><a href="../menu.php">Back to Main Menu</a></p></td>
				<td>
					<div align="left">
						<p></p>
						<ul>
						  <li><span class="basetext"><a href="vieworders.php">View Purchase Order Sheets</a></span><br>
This will allow a printable version of the orders from our customers.  It provides views of the stamps used to create items.
  <br>  
						  <li><span class="basetext"><a href="MYOBreport.php">MYOB Upload Center </a></span><br>
						    This area will allow you to upload customer, item and invoice data into MYOB for accounting. <br>                                                        
                          <li><span class="basetext"><a href="FedExReport.php">FedEx Import File Creator</a></span><br>
                            This will create a file usable for import into FedEx's website for easy label creation. <br>
                          <li><span class="basetext"><a href="customer.php">Customer Management</a> </span><br>
							The ability to add, update, view and edit information about customers is through this link.

					    </ul>
						<p></p>
				  </div>
				</td>
			</tr>
		</table>
		<p></p>
	</body>
</html>
