<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 10/04/04
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
	if ($_SESSION['canManageEvents']!="Yes"){
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
		<title>Event Addition Page</title>
		<style type="text/css" media="screen">
		<!--
.title { color: blue; font-style: normal; font-weight: bold; font-size: large; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.errormsg { color: red; font-style: normal; font-weight: bolder; font-size: small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetext { color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.style1 {font-size: medium}
.style4 {font-size: xx-small}
--></style>
<script language="javascript1.2" type="text/javascript">
	function changegraphic(){
		if (document.FormName.txtGraphicLocation.value!=""){
			document.eventgraphic.src="../../" + document.FormName.txtGraphicLocation.value;
		} else {
			document.eventgraphic.src="../../stamps/blankstamp.gif";
		};
	};
	function validateForm(){
		var ErrMsg="";
		if (document.FormName.txtImageTitle.value==""){
			ErrMsg="You must enter an event image title to continue.\n";
		};
		if (document.FormName.fileImage.value==""){
			ErrMsg+="You choose an image file to continue.\n";
		};
		if (ErrMsg!=""){
			alert(ErrMsg);
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
						<span class="title">Event Image Addition Page</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top" class="title style1"><p>Navigation:</p>
				  <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br>
				      <a href="menu.php">Back to Event Menu</a></p>
				  <p>&nbsp;</p>
				  <p><br>
				  </p>
			    </td>
				<td>
					<div align="center">
						<form action="addeventimage2.php" method="post" enctype="multipart/form-data" name="FormName" onSubmit="return validateForm();">
							<table width="450" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td><p class="basetext">Event Image Title:<br>
									  <span class="style4">(No spaces or punctuation characters.)<br>
									  </span></p>								    </td>
									<td><input type="text" name="txtImageTitle" size="60" ></td>
								</tr>
								<tr>
									<td><p class="basetext">Image file<br>
									  <span class="style4">(JPG IMAGES ONLY)</span></p>								    </td>
									<td><p>
									  <input type="file" name="fileImage" size="45">
									  <br>
									  <span class="style4">Please keep images smaller than 1 MB.</span>									</p>
								  </td>
								</tr>
								<tr>
									<td></td>
									<td>
										<div align="right">
											<input type="submit" name="sbSubmit" value="Submit" ><input name="sbReset" type="reset" value="Reset" ></div>
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