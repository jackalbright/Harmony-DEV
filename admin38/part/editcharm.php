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
	$txtCharmID=$_POST['txtCharmID'];
	include ('../../includes/database.inc');
    $result = mysql_query ("SELECT * FROM `charm` WHERE charm_id='$txtCharmID'", $database);
    while ($event = mysql_fetch_object($result))
        {
		   $txtCharmID=$event->charm_id;
		   $txtCharmName=$event->name;
		   $txtImageLocation=$event->graphic_location;
		   $cbAvailable=$event->available;
		   $cbPopular=$event->popular;
         };
     mysql_close($database);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<meta name="generator" content="Adobe GoLive 6">
		<title>Charm Addition Page</title>
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
	function changeCharm(){
		if (document.frmCharm.txtThumbnailLocation.value !=""){
			document.imgCharm.src="../.."+document.frmCharm.txtThumbnailLocation.value;
		} else {
			document.imgCharm.src="../../thumbnails/blankstamp.gif";
		};
		return;
	};
	function setGraphics(){
		document.frmCharm.txtThumbnailLocation.value="/borders/" + toLowerCase(document.frmCharm.txtCharmName.value) + ".gif";
		changeCharm();
	};
	function clearFields(){
		document.frmCharm.txtThumbnailLocation.value="";
		document.frmCharm.txtCharmName.value="";
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
						<span class="title">Charm Edit Page</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top" class="title style3"><p>Navigation:</p>
			      <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br><a href="menu.php">Back to Parts Menu</a><br>
                      <a href="charmsmenu.php">Back to Charm Menu</a> </p>
			      <p>Sample:<br>
			        <img name="imgCharm" src="../../<?php echo $txtImageLocation; ?>">			    </p>
			      <p>&nbsp; </p></td>
				<td>
					<div align="center">
						<form action="editcharm2.php" method="post" name="frmCharm">
							<table width="450" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td></td>
									<td>
										<div align="right">
											<input type="submit" name="sbSubmit" value="Next --&gt;"><input type="reset" name="sbReset" value="Clear Form" onClick="clearFields();"></div>
									</td>
								</tr>
								<tr>
									<td><span class="basetext">Charm<br>
									  Name
								    :
									      <input type="hidden" name="txtCharmID" value="<?php echo $txtCharmID; ?>">
									</span></td>
									<td><input type="text" name="txtCharmName" size="60" onChange="setGraphics();" value="<?php echo $txtCharmName; ?>"></td>
								</tr>
								<tr>
									<td><span class="basetext">Thumbnail Location:</span></td>
									<td><input type="text" name="txtThumbnailLocation" size="60" onChange="changeCharm();" value="<?php echo $txtImageLocation; ?>"></td>
								</tr>
								<tr>
								  <td><div align="right">
								    <input name="cbAvailable" type="checkbox" id="cbAvailable" value="True" <?php if ($cbAvailable=='Yes'){echo "checked";};?>>
							      </div></td>
								  <td class="basetext">This charm is available for use. </td>
							  </tr>
								<tr>
								  <td><div align="right">
								    <input name="cbPopular" type="checkbox" id="cbPopular" value="1" <?php if ($cbPopular){echo "checked";};?>>
							      </div></td>
								  <td class="basetext">This charm is popular.</td>
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
