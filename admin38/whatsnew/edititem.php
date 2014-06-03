<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 02/09/05
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
<?php
   $itemID=$_POST['txtItemID'];
	include ('../../includes/database.inc');
    $result = mysql_query ("SELECT *, UNIX_TIMESTAMP(start_date) as codedStart, UNIX_TIMESTAMP(end_date) as codedEnd FROM `spotlight_items` WHERE spotlight_item_id='$itemID'", $database);
    while ($item = mysql_fetch_object($result))
        {
           $startdate['month']=date('n', $item->codedStart);
           $startdate['day']=date('j', $item->codedStart);
           $startdate['year']=date('Y', $item->codedStart);
           $enddate['month']=date('n', $item->codedEnd);
           $enddate['day']=date('j', $item->codedEnd);
           $enddate['year']=date('Y', $item->codedEnd);
           $txtItemName=$item->item_name;
           $txtFileAddress=$item->include_file_loc;
           $txtCSSAddress=$item->stylesheet_loc;
         };
     mysql_close($database);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<meta name="generator" content="Adobe GoLive 6">
		<title>Spotlight Item Edit Page</title>
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
		if (document.FormName.txtIntroText.value==""){
			ErrMsg="You must enter an event title to continue.\n";
		};
		if (document.FormName.txtMainText.value==""){
			ErrMsg+="You must enter an event description to continue.\n";
		};
		if (document.FormName.txtURLAddress.value==""){
			ErrMsg+="You must enter a target URL to continue.\n";
		};
		if (document.FormName.txtGraphicLocation.value==""){
			ErrMsg+="You must enter a graphic location to continue.\n";
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
						<span class="title">Spotlight Item Edit Page</span></div>
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
						      <input type="hidden" name="hdnItemID" value="<?php echo $itemID; ?>">
							<table width="450" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td><span class="basetext"><strong>Item Name:</strong></span></td>
									<td><input type="text" name="txtItemName" size="60" value="<?php echo $txtItemName; ?>"></td>
								</tr>
								<tr>
								  <td><span class="basetext"><strong>File URL:</strong><br>
                                      <span class="style4">(Enter the address of the include file for the item.) </span></span><br>									</td>
									<td><input type="text" name="txtFileAddress" size="60" value="<?php echo $txtFileAddress; ?>"></td>
								</tr>
								<tr>
									<td><p class="basetext"><strong>CSS URL:</strong><br>
									    <span class="style4">(Enter the address of the stylesheet, if one exists, for the item.)
                                        </span> </p>								    </td>
									<td><input type="text" name="txtCSSAddress" size="60" value="<?php echo $txtCSSAddress; ?>"></td>
								</tr>
								<tr>
									<td><span class="style6">Start Date:</span></td>
								  <td><input type="text" name="txtStartMonth" size="4" value="<?php echo $startdate['month']; ?>">
/
  <input type="text" name="txtStartDay" size="4" value="<?php echo $startdate['day']; ?>">
/
<input type="text" name="txtStartYear" size="8" value="<?php echo $startdate['year']; ?>">
<span class="style4">(mm/dd/yyyy)</span></td>
								</tr>
								<tr>
									<td><span class="style6">End Date:</span></td>
								  <td><input type="text" name="txtEndMonth" size="4" value="<?php echo $enddate['month']; ?>">
/
  <input type="text" name="txtEndDay" size="4" value="<?php echo $enddate['day']; ?>">
/
<input type="text" name="txtEndYear" size="8" value="<?php echo $enddate['year']; ?>">
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