<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 01/11/05
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
	$txtInvoice = (array)$_POST['txtInvoice'];
	foreach ($txtInvoice as $element){
		$newarraytext = $newarraytext . " " . $element;
	}
	$arraytext = trim($newarraytext, " ");
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
.style1 {	font-size: 16px;}
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
					<div align="center" class="title">
						MYOB Upload Center </div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top"><p class="title style1">Navigation:</p>
				  <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br>
                      <a href="menu.php">Back to Order Menu</a><br>
                      <a href="MYOBreport.php">Back to MYOB Center</a></p></td>
				<td valign="top">				  <div align="left">
					  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="28%"><img src="../step2.gif" align="left"></td>
    <td width="72%">						
						<form name="newcustomerForm" action="newMYOBCustomer.php" method="post">
						    <p align="center">Now that you have selected a record (or more) to upload, click on the button below to download the customer information into a file for importing into MYOB. 
								<input name="txtInvoice" type="hidden" value="<?php echo $arraytext; ?>">
								<BR/>
								<input type="submit" name="Submit" value="Download the Customer Information" align="middle">
						</p>
			  </form>
<!--						<form name="customerForm" action="MYOBCustomer.php" method="post">
						    <p align="center">Now that you have selected  record to upload, click on the button below to download the customer information into a file for importing into MYOB. 
								<input name="txtInvoice" type="hidden" value="<?php echo $txtInvoice; ?>">
								<BR/>
								<input type="submit" name="Submit" value="Download the Customer Information" align="middle">
														</p>
			  </form>-->
</td>
  </tr>
  <tr>
    <td><img src="../step3.gif" width="136" height="198"></td>
    <td>
							<form name="itemForm" action="MYOBItem.php" method="post">
							    <p align="center">After the customer information is downloaded, the items for the invoice(s) must be imported into the database. Click the button below to download the items types. 
								<input name="txtInvoice" type="hidden" value="<?php echo $arraytext; ?>">
								<BR/><input type="submit" name="Submit" value="Download the Item Information">
						</p>
			  </form>
</td>
  </tr>
  <tr>
    <td>&nbsp;      </td>
    <td>&nbsp;</td>
  </tr>
</table>

					    </div>
				</td>
			</tr>
		</table>
		<p></p>
</body>

</html>
