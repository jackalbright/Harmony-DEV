<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 9/27/04
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
	// PHP configuration directives for this script
	ini_set ('max_execution_time', 180);
	ini_set ('memory_limit', 20000000);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<meta name="generator" content="Adobe GoLive 6">
		<title>Stamp Addition Page</title>
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
.style4 {
	font-size: xx-small;
	font-style: italic;
}
--></style>
<script language="javascript" type="text/javascript">
	function changeSurcharge(){
		return True;
	};
	
	function changeThumbnail(){
		if (document.frmStamp.txtThumbnailLocation.value !=""){
			document.imgThumbnail.src="../.."+document.frmStamp.txtThumbnailLocation.value;
		} else {
			document.imgThumbnail.src="../../thumbnails/blankstamp.gif";
		};
		return;
	};
	function changeStamp(){
		if (document.frmStamp.txtImageLocation.value !=""){
			document.imgStampImage.src="../.."+document.frmStamp.txtImageLocation.value;
		} else {
			document.imgStampImage.src="../../stamps/blankstamp.gif";
		}; 
		return;
	};
	function setGraphics(){
		document.frmStamp.txtThumbnailLocation.value="/thumbnails/" + document.frmStamp.txtCatalogNumber.value + ".gif";
		document.frmStamp.txtImageLocation.value="/stamps/" + document.frmStamp.txtCatalogNumber.value + ".gif";
		changeThumbnail();
		changeStamp();		
	};
	function validateForm(){
		if (document.frmStamp.txtCatalogNumber.value == ""){
			alert("You must enter a Catalog Number to continue.");
			return false;
		};
		if (document.frmStamp.fileStampImage.value == ""){
			alert("You must include a file image to continue.");
			return false;
		};
		return true;
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
						<span class="title">Stamp Image Addition Page</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top" class="title style3"><p>Navigation:</p>
			      <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br><a href="menu.php">Back to Parts Menu</a><br>
                      <a href="stampsmenu.php">Back to Stamp Menu</a> </p>
			      <p>&nbsp;</p>
			      <p>&nbsp; </p></td>
				<td>
					<div align="center">
						<form action="addstamppic2.php" method="post" enctype="multipart/form-data" name="frmStamp" onSubmit="return validateForm();">
						  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="30%">Catalog Number: </td>
                              <td width="70%"><input type="text" name="txtCatalogNumber" width="300">
                              <br>
                              <span class="style4">(Note: No spaces or punctuation should be in the catalog number.) </span></td>
                            </tr>
                            <tr>
                              <td>File image: </td>
                              <td><input type="file" name="fileStampImage"></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td><div align="right">
                                <input type="submit" name="Submit" value="Send Image File">
                                <input type="button" name="Clear" value="Clear">
                              </div></td>
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
