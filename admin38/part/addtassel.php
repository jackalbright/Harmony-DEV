<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 9/20/04
******************************************************************************************/
	session_start();
	if (!array_key_exists('UName', $_SESSION)){
		header ('Location: ../index.php');
	} else {
		$manageOrders=$_SESSION['canManageOrders'];
		$manageParts=$_SESSION['canManageParts'];
		$manageUsers=$_SESSION['canManageUsers'];
		$manageItems=$_SESSION['canManageItems'];
		$manageEvents=$_SESSION['canManageEvents'];
		$manageDatabase=$_SESSION['canManageDatabase'];
		$manageTestimonials=$_SESSION['canManageTestimonials'];
	};
	if ($_SESSION['canManageParts']!="Yes"){
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
		<title>Tassel Addition Page</title>
		<style type="text/css" media="screen">
		<!--
.title { color: blue; font-style: normal; font-weight: bold; font-size: large; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.errormsg { color: red; font-style: normal; font-weight: bolder; font-size: small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetext { color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetextgrey { color: gray; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.style2 {color: black; font-weight: normal; font-size: 9px; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular; }
.basetextSurcharge {
color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular
}
.style3 {font-size: medium}
.style4 {	color: black;
	font-weight: normal;
	font-size: xx-small;
	font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular;
	font-style: italic;
}
--></style>
<script language="javascript" type="text/javascript">
	function sampleColor(){
		document.getElementById("tblTassel").style.backgroundColor= document.frmTassel.txtColorCode.value;
	};
	function clearFields(){
		document.frmTassel.txtColorCode.value="";
		document.frmTassel.txtTasselName.value="";
		changeCharm();
	};
</script>

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
						<span class="title">Tassel Addition Page</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top" class="title style3"><p>Navigation:</p>
			      <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br><a href="menu.php">Back to Parts Menu</a><br>
                      <a href="tasselsmenu.php">Back to Tassel Menu</a> </p>
			      <p>Sample:<br>
			      </p>
			      <table id="tblTassel" width="100" height="100" border="0">
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                  </table>
			      <p>&nbsp;			        </p>
			      <p>&nbsp; </p></td>
				<td valign="top">
					<div align="center">
						<form action="addtassel2.php" method="post" name="frmTassel">
							<table width="450" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td></td>
									<td>
										<div align="right">
											<input type="submit" name="sbSubmit" value="Next --&gt;"><input type="reset" name="sbReset" value="Clear Form" onClick="clearFields();"></div>
									</td>
								</tr>
								<tr>
									<td><span class="basetext">Tassel Color <br>
									  Name
							      :</span></td>
									<td><input type="text" name="txtTasselName" size="60"></td>
								</tr>
								<tr>
									<td><span class="basetext">Color Code: <BR>(RGB)</span></td>
								  <td><input type="text" name="txtColorCode" size="60"  onChange="javascript: sampleColor();">
								    <span class="style4"><br>
								    Enter information as RRGGBB. For example, 000000 is black and FFFFFF is white.</span> </td>
								</tr>
								<tr>
								  <td><div align="right">
								    <input name="cbAvailable" type="checkbox" id="cbAvailable" value="True" checked>
							      </div></td>
								  <td class="basetext">This tassel is available for use. </td>
							  </tr>
								<tr>
									<td></td>
									<td>
										<div align="right">
											<input type="submit" name="sbSubmit" value="Next --&gt;"><input type="reset" name="sbReset" value="Clear Form" onClick="clearFields();"></div>
									</td>
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