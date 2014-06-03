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
	$imageLocation = "";
	if (array_key_exists('ImageLoc', $_GET)){
		$imageLocation = $_GET["ImageLoc"];
	};
	$today=getdate();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<meta name="generator" content="Adobe GoLive 6">
		<title>Spotlight Item Addition Page</title>
		<style type="text/css" media="screen">
		<!--
.title { color: blue; font-style: normal; font-weight: bold; font-size: large; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.errormsg { color: red; font-style: normal; font-weight: bolder; font-size: small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetext { color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.style1 {font-size: medium}
.style4 {font-size: xx-small}
.style6 {color: black; font-weight: bold; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular; }
--></style>
<script language="javascript1.2" type="text/javascript">
		function displayItemAd(){
			var targetURI = 'showspotlight.php?stylesheet=' + document.FormName.txtCSSAddress.value + '&include_file=' + document.FormName.txtFileAddress.value;
			var targetTitle = 'Spotlight Item';
			var targetAttributes = "toolbar=no,width=380,height=300,status=yes,resize=yes,scrollbars=yes,menubar=no";
			detailWindow = open(targetURI, targetTitle, targetAttributes);
			detailWindow.focus();
			return false;
		};

	function validateForm(){
		var ErrMsg="";
		if (document.FormName.txtItemName.value==""){
			ErrMsg="You must enter a name for the spotlighted item to continue.\n";
		};
		if (document.FormName.txtFileAddress.value==""){
			ErrMsg+="You must enter an address for the include file to continue.\n";
		};
		if (document.FormName.txtStartMonth.value=="" || document.FormName.txtStartDay.value=="" || document.FormName.txtStartYear.value==""){
			ErrMsg+="You must enter a start date to continue.\n";
		};
		if (document.FormName.txtEndMonth.value=="" || document.FormName.txtEndDay.value=="" || document.FormName.txtEndYear.value==""){
			ErrMsg+="You must enter a end date to continue.\n";
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
						<span class="title">Spotlight Item  Addition Page</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top" class="title style1"><p>Navigation:</p>
				  <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br>
				      <a href="menu.php">Back to What's New Menu</a><br>
				      <br>
				  </p>
				  <p>Show Item:</p>
				    <p class="basetext"><a href="" onclick="javascript:return displayItemAd()">Display Special Item Ad</a></p>
				  <p><br>
				  </p>
			    </td>
				<td>
					<div align="center">
						<form action="itemsubmit.php" method="post" enctype="multipart/form-data" name="FormName" onSubmit="return validateForm();">
						      <input type="hidden" name="hdnItemID" value="AAA">
							<table width="450" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td><span class="style6">Item Name:</span></td>
									<td><input type="text" name="txtItemName" size="60" ></td>
								</tr>
								<tr>
								  <td><span class="basetext"><strong>File URL:</strong><br>
                                      <span class="style4">(Enter the address of the include file for the item.) </span></span><br>									</td>
									<td><input type="text" name="txtFileAddress" size="60" value="/spotlight/"></td>
								</tr>
								<tr>
									<td><p class="basetext"><strong>CSS URL:</strong><br>
									    <span class="style4">(Enter the address of the stylesheet, if one exists, for the item.)
                                        </span> </p>								    </td>
									<td><input type="text" name="txtCSSAddress" size="60" value="/stylesheets/"></td>
								</tr>
								<tr>
									<td><span class="style6">Start Date:</span></td>
								    <td><input type="text" name="txtStartMonth" size="4" value="<?php echo $today['mon']; ?>">								    
								      /
								      <input type="text" name="txtStartDay" size="4" value="<?php echo $today['mday']; ?>">
								      /
								      <input type="text" name="txtStartYear" size="8" value="<?php echo $today['year']; ?>"> 
						          <span class="style4">(mm/dd/yyyy) </span></td></tr>
								<tr>
									<td><span class="style6">End Date:</span></td>
									<td><input type="text" name="txtEndMonth" size="4" value="<?php echo $today['mon']; ?>">
/
  <input type="text" name="txtEndDay" size="4" value="<?php echo $today['mday']; ?>">
/
<input type="text" name="txtEndYear" size="8" value="<?php echo $today['year']; ?>">
<span class="style4">(mm/dd/yyyy)</span></td>
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