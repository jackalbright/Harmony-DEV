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
<?php
	$today=getdate();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<title>View Purchase Orders</title>
		<style type="text/css" media="screen">
		<!--
.title { color: blue; font-style: normal; font-weight: bold; font-size: large; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.errormsg { color: red; font-style: normal; font-weight: bolder; font-size: small; line-height: normal; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetext { color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.style1 {
	font-size: 10px;
	font-style: italic;
}
.style2 {font-size: medium}
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
						<span class="title">View Purchase Orders</span></div>
				</td>
			</tr>
			<tr>
			  <td width="200" valign="top"><p class="title style2">Navigation:</p>
				  <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br>
		      <a href="menu.php">Back to Order Menu</a></p>			  </td>
				<td>
					<div align="center">
						<form action="vieworders1.php" method="post" name="ViewOrderForm1">
							<p>Enter a range of dates for the report.  If you just want a report for a particular date, just enter the information in the Start Date.<input type="hidden" name="hdnType" value="1" border="0"></p>
							<table width="400" border="0" cellspacing="2" cellpadding="0">
								<tr>
									<td width="150"><span class="basetext">Enter Start Date:</span></td>
								  <td><input type="text" name="txtStartMonth" value="<?php echo $today['mon'];?>" size="4" border="0">/<input type="text" name="txtStartDay" value="<?php echo $today['mday'];?>" size="4" border="0">/<input type="text" name="txtStartYear" value="<?php echo $today['year'];?>" size="8" border="0"> 
									  <span class="style1">(mm/dd/yyyy)</span> </td>
								</tr>
								<tr>
									<td width="150"><span class="basetext">Enter End Date:</span></td>
								  <td><input type="text" name="txtEndMonth" value="<?php echo $today['mon'];?>" size="4" border="0">/<input type="text" name="txtEndDay" value="<?php echo $today['mday'];?>" size="4" border="0">/<input type="text" name="txtEndYear" value="<?php echo $today['year'];?>" size="8" border="0">	  <span class="style1">(mm/dd/yyyy)</span>							    </td>
								</tr>
								<tr>
									<td width="150"></td>
									<td><input type="submit" name="sbSubmit" value="Find Order" border="0"></td>
								</tr>
							</table>
						</form>
						<form action="vieworders1.php" method="post" name="ViewOrderForm2">
							
							Or look up Purchase Orders by customer name.
<input type="hidden" name="hdnType" value="2" border="0">
							<table width="400" border="0" cellspacing="2" cellpadding="0">
								<tr>
									<td width="150"><span class="basetext">Customer Name:</span></td>
									<td><select name="txtCustomerID" size="1">
									<?php
											include ('../../includes/database.inc');
											$result2 = mysql_query ("SELECT First_Name, Last_Name, customer_id, email_Address FROM customer ORDER BY Last_Name", $database);
											while ($row2 = mysql_fetch_row($result2)){
												echo"<option value='$row2[2]'>$row2[1], $row2[0] ($row2[3])</option>";
											};
											mysql_close($database);
									?>
										</select></td>
								</tr>
								<tr>
									<td width="150"></td>
									<td><input type="submit" name="sbSubmit" value="Find Order" border="0"></td>
								</tr>
							</table>
							<p></p>
						</form>
						<form action="vieworders1.php" method="post" name="ViewOrderForm3">
							Or look up Purchase Orders by company.
<input type="hidden" name="hdnType" value="3" border="0">
							<table width="400" border="0" cellspacing="2" cellpadding="0">
								<tr>
									<td width="150"><span class="basetext">Company Name:</span></td>
									<td><select name="txtCustomerID" size="1">
									<?php
											include ('../../includes/database.inc');
											$result2 = mysql_query ("SELECT First_Name, Last_Name, customer_id, Company FROM customer WHERE NOT (Company='') ORDER BY Company", $database);
											while ($row2 = mysql_fetch_row($result2)){
												echo"<option value='$row2[2]'>$row2[3] ($row2[1], $row2[0])</option>";
											};
											mysql_close($database);
									?>
										</select></td>
								</tr>
								<tr>
									<td width="150"></td>
									<td><input type="submit" name="sbSubmit" value="Find Order" border="0"></td>
								</tr>
							</table>
						</form>
						<form action="vieworders2.php" method="get" name="viewOrdersByNumber">
							<h4>Or lookup an order by order number</h4>
							<input type="text" id="purchaseID" name="purchaseID" size="10"><input type="submit" value="Find Order">
						</form>
					</div>
				</td>
			</tr>
		</table>
		<p></p>
	</body>
</html>
