<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 06/1/05
******************************************************************************************/

//***************************************************
//       ENcrypt class May 2008

include_once ("../../includes/classDefinitions.inc");
include_once ("../../includes/encdecclass.php");
$encdec = new EncDec;
//***************************************************


	session_start();
	if (!array_key_exists('UName', $_SESSION)){
		setcookie("admin_goto", $_SERVER['REQUEST_URI'], 0, '/');
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
	if ($_SESSION['canManageOrders']!="Yes"){
		header ('Location: ../menu.php');
		exit(0);
	};

	include_once ('../../includes/admin.inc');
	include_once ('../../includes/settings.inc');
	include_once ('../../includes/database.inc');

// Get Purchase ID and Recalculate Order if Necessary
// NOTE: using array_key_exists allows NULL purchaseID. Suggest we switch to if(isset($_GET['purchaseID') and isnumeric($_GET['purchaseID')) Jack Albright 20140416
	if (array_key_exists('purchaseID', $_GET)){
		$purchaseID=$_GET['purchaseID'];
		$txtUpdate="false";
	} elseif (array_key_exists('hdnPurchaseID', $_POST)){
		$purchaseID=$_POST['hdnPurchaseID'];
		$txtShipper=$_POST['txtShipper'];
		if ($txtShipper!="Not Shipped"){
			$result = mysql_query ("UPDATE purchase SET Shipping_Method='$txtShipper' WHERE purchase_id=$purchaseID", $database); 	
		};
		$txtTrackingNumber=$_POST['txtTrackingNumber'];
		$result = mysql_query ("UPDATE purchase SET tracking_number='$txtTrackingNumber' WHERE purchase_id=$purchaseID", $database); 	
		$txtOrderStatus=$_POST['txtOrderStatus'];
		$result = mysql_query ("UPDATE purchase SET Order_Status='$txtOrderStatus' WHERE purchase_id=$purchaseID", $database); 	
		$cbCancel=(array)$_POST['cbCancel'];
		foreach ($cbCancel as $value){
			$itemCancel[$value]="No";
		};
		$txtUpdate="true";
		$result = mysql_query ("UPDATE order_item SET accepted='Yes' WHERE purchase_id=$purchaseID", $database); 	
		foreach ($cbCancel as $value){
			$result = mysql_query ("UPDATE order_item SET accepted='No' where order_item_id=$value", $database); 	
		};
	};
	#mysql_close($database);
	include("../../includes/order_details.php");
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
.style1 {font-weight: bold}
--></style>
<?php
		echo "<script language=\"javascript\" type=\"text/javascript\">";
		echo "function recalcTotal(){";
		echo "location.href=\"vieworders2.php?purchaseID=$purchaseID\";};";
		echo "</script>";
?>
	</head>

	<body bgcolor="#ffffff">
		<form action="vieworders2.php" method="post" name="POForm">
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
				  <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br />
				      <a href="menu.php">Back to Order Menu</a></p>
			  </td>
				<td>
					<div align="center">
						<? print_order_customer($purchaseID, $database, !empty($_REQUEST['readonly'])); ?>
					</div>
				</td>
			</tr>
		</table>

		<? print_order_items($purchaseID, $database, false); ?>
	</form>
	</body>
</html>
