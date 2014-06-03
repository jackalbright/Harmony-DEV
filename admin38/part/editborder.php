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
<?php 
	$txtBorderID=$_POST['txtBorderID'];
	include ('../../includes/database.inc');
    $result = mysql_query ("SELECT * FROM `border` WHERE border_id='$txtBorderID'", $database);
    while ($event = mysql_fetch_object($result))
        {
		   $txtBorderID=$event->border_id;
		   $txtBorderName=$event->name;
		   $txtImageLocation=$event->location;
		   $cbAvailable=$event->available;
         };
     mysql_close($database);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<meta name="generator" content="Adobe GoLive 6">
		<title>Border Addition Page</title>
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
--></style>
<script language="javascript" type="text/javascript">
	function changeBorder(){
		if (document.frmBorder.txtThumbnailLocation.value !=""){
			document.imgBorder.src="../.."+document.frmBorder.txtThumbnailLocation.value;
		} else {
			document.imgBorder.src="../../thumbnails/blankstamp.gif";
		};
		return;
	};
	function setGraphics(){
		document.frmBorder.txtThumbnailLocation.value="/borders/" + toLowerCase(document.frmBorder.txtBorderName.value) + ".gif";
		changeBorder();
	};
	function clearFields(){
		document.frmBorder.txtThumbnailLocation.value="";
		document.frmBorder.txtBorderName.value="";
		changeBorder();
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
						<span class="title">Border Edit Page</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top" class="title style3"><p>Navigation:</p>
			      <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br><a href="menu.php">Back to Parts Menu</a><br>
                      <a href="bordersmenu.php">Back to Border Menu</a> </p>
			      <p>Sample:<br>
			        <img name="imgBorder" src="../..<?php echo $txtImageLocation; ?>">			    </p>
			      <p>&nbsp; </p></td>
				<td>
					<div align="center">
						<form action="editborder2.php" method="post" name="frmBorder">
							<table width="450" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td></td>
									<td>
										<div align="right">
											<input type="submit" name="sbSubmit" value="Next --&gt;"><input type="reset" name="sbReset" value="Clear Form" onClick="clearFields();"></div>
									</td>
								</tr>
								<tr>
									<td><span class="basetext">Border<br>
									  Name
								    :
									      <input type="hidden" name="txtBorderID" value="<?php echo $txtBorderID; ?>">
									</span></td>
									<td><input type="text" name="txtBorderName" size="60" onchange="setGraphics();" value="<?php echo $txtBorderName; ?>"></td>
								</tr>
								<tr>
									<td><span class="basetext">Thumbnail Location:</span></td>
									<td><input type="text" name="txtThumbnailLocation" size="60" onchange="changeBorder();" value="<?php echo $txtImageLocation; ?>"></td>
								</tr>
								<tr>
								  <td><div align="right">
								    <input name="cbAvailable" type="checkbox" id="cbAvailable" value="True" <?php if ($cbAvailable=='Yes'){echo "checked";};?>>
							      </div></td>
								  <td class="basetext">This border is available for use. </td>
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