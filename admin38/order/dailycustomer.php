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
		<title>Create Daily Report</title>
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
						<span class="title">Create Customer Report</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top"><p class="title style1">Navigation:</p>
				  <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br>
                      <a href="menu.php">Back to Order Menu</a></p></td>
				<td>
					<div align="center">
						<form action="dailycustomer2.php" method="get" name="DailyReportDateForm">
							<p>Select an order from which you wish to import customer information. </p>
							<table width="400" border="0" cellspacing="2" cellpadding="0">
								<tr>
									<td><span class="basetext">Select Order ID:</span></td>
									<td><select name="txtPurchaseID" size="1">
                                      <?php
											include ('../../includes/database.inc');
											$result2 = mysql_query ("SELECT p.purchase_id, c.first_name, c.last_name FROM purchase p, customer c WHERE p.customer_id=c.customer_id ORDER BY p.purchase_id DESC", $database);
											while ($row2 = mysql_fetch_row($result2)){
												echo"<option value='$row2[0]'>Order:  $row2[0] ($row2[1] $row2[2])</option>";
											};
											mysql_close($database);
									?>
                                    </select></td>
								</tr>
								<tr>
									<td></td>
									<td><input type="submit" name="sbSubmit" value="Create Report" border="0"></td>
								</tr>
							</table>
						</form>
					</div>
				</td>
			</tr>
		</table>
		<p></p>
	</body>

</html>
