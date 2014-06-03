<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 11/23/04
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
<?php
	if ($_POST['hdnType']=="1"){
		$txtStartMonth=$_POST['txtStartMonth'];
		$txtStartDay=$_POST['txtStartDay'];
		$txtStartYear=$_POST['txtStartYear'];
		$txtEndMonth=$_POST['txtEndMonth'];
		$txtEndDay=$_POST['txtEndDay'];
		$txtEndYear=$_POST['txtEndYear'];
		if ($txtEndMonth==$txtStartMonth && $txtEndDay==$txtStartDay && $txtEndYear==$txtStartYear){
			$txtRange="single";
		} else {
			$txtRange="multiple";
		};
		include ('../../includes/database.inc');
		if ($txtRange=="single") {
			$result = mysql_query ("SELECT MONTH(Order_Date) as OrderMonth, DAYOFMONTH(Order_Date) as OrderDay, YEAR(Order_Date) as OrderYear, Order_Status, Customer_ID, purchase_id FROM purchase WHERE Order_Date='$txtStartYear-$txtStartMonth-$txtStartDay' ORDER BY Order_Date, Purchase_ID", $database); 
		} elseif ($txtRange=="multiple"){
			$result = mysql_query ("SELECT MONTH(Order_Date) as OrderMonth, DAYOFMONTH(Order_Date) as OrderDay, YEAR(Order_Date) as OrderYear, Order_Status, Customer_ID, purchase_id FROM purchase WHERE Order_Date BETWEEN '$txtStartYear-$txtStartMonth-$txtStartDay' AND '$txtEndYear-$txtEndMonth-$txtEndDay' ORDER BY Order_Date, Purchase_ID", $database);
		};
		while ($row = mysql_fetch_object($result)){
			$orderdate[]=$row->OrderMonth . "-" . $row->OrderDay . "-" . $row->OrderYear;
			$orderstatus[]=$row->OrderStatus;
			$customerID[]=$row->Customer_ID;
			$purchaseID[]=$row->purchase_id;
		};
		mysql_close($database);
	} else if ($_POST['hdnType']=="2" || $_POST['hdnType']=="3"){
		$customer=$_POST['txtCustomerID'];
		include ('../../includes/database.inc');
		$result = mysql_query ("SELECT MONTH(Order_Date) as OrderMonth, DAYOFMONTH(Order_Date) as OrderDay, YEAR(Order_Date) as OrderYear, Order_Status, Customer_ID, purchase_id FROM purchase WHERE customer_id='$customer' ORDER BY Order_Date DESC, Purchase_ID DESC", $database); 
		while ($row = mysql_fetch_object($result)){
			$orderdate[]=$row->OrderMonth . "-" . $row->OrderDay . "-" . $row->OrderYear;
			$orderstatus[]=$row->OrderStatus;
			$customerID[]=$row->Customer_ID;
			$purchaseID[]=$row->purchase_id;
		};
		mysql_close($database);
	};
	foreach ($purchaseID as $key=>$value){
		include ('../../includes/database.inc');
		$result = mysql_query ("SELECT First_Name, Last_Name, Company FROM customer WHERE customer_id='$customerID[$key]'", $database); 
		while ($row = mysql_fetch_object($result)){
			$FirstName[$key]=$row->First_Name;
			$LastName[$key]=$row->Last_Name;
			$Company[$key]=$row->Company;
		};
		mysql_close($database);
		$items="";
		$firstLine[$key]="<li><span class=\"basetext\"><a href=\"./vieworders2.php?purchaseID=$purchaseID[$key]\">Order Date: $orderdate[$key] Order Number:  $purchaseID[$key]  Customer: $LastName[$key], $FirstName[$key] ($Company[$key])</a><br>"; 
	};	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<meta name="generator" content="Adobe GoLive 6">
		<title>View Purchase Orders</title>
		<style type="text/css" media="screen">
		<!--
.title { color: blue; font-style: normal; font-weight: bold; font-size: large; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.errormsg { color: red; font-style: normal; font-weight: bolder; font-size: small; line-height: normal; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetext { color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, sans-serif}
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
						<span class="title">View Purchase Orders</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top"><p class="title style1">Navigation:</p>
				  <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br>
				      <a href="menu.php">Back to Order Menu</a></p>
			  </td>
				<td>
					<div align="center">
						<p>Click on one of the orders below to view the particular purchase order.</p>
					</div>
					<ul>
						<div align="left">
						<?php
						foreach ($firstLine as $key=>$value){
							echo "$firstLine[$key]";
						};
						?>
						</div>
					</ul>
					<div align="center">
						<p></p>
					</div>
				</td>
			</tr>
		</table>
		<p></p>
	</body>
</html>
