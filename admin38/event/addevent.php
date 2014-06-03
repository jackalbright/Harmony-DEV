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
						<span class="title">Event Addition Page</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top" class="title style1"><p>Navigation:</p>
				  <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br>
				      <a href="menu.php">Back to Event Menu</a></p>
				  <p>Graphic</p>
				  <p><img name="eventgraphic" src="<?php if ($imageLocation == ""){ echo "../../stamps/blankstamp.gif"; } else { echo "../.." . $imageLocation;  }; ?>"><br>
				  </p>
			    </td>
				<td>
					<div align="center">
						<form action="eventsubmit.php" method="post" enctype="multipart/form-data" name="FormName" onSubmit="return validateForm();">
						      <input type="hidden" name="hdnEventID" value="AAA">
							<table width="450" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td><span class="basetext">Event Title:</span></td>
									<td><input type="text" name="txtIntroText" size="60" ></td>
								</tr>
								<tr>
								  <td><span class="basetext">Event Description:</span><br>									</td>
									<td><textarea name="txtMainText" rows="6" cols="60"></textarea></td>
								</tr>
								<tr>
									<td><p class="basetext">Target URL:<br>
									    <span class="style4">(Enter the address of the page this event will point at.)
                                        </span> </p>								    </td>
									<td><input type="text" name="txtURLAddress" size="60"></td>
								</tr>
								<tr>
									<td><span class="basetext">Graphic Location:</span></td>
								  <td><input type="text" name="txtGraphicLocation" size="60" value="<?php if ($imageLocation){echo $imageLocation;} else {echo '/event-images/';}; ?>" onchange="changegraphic();">
							      </td>
								</tr>
								<tr>
									<td><span class="basetext">Start Date:</span></td>
								  <td><input type="text" name="txtStartMonth" size="4" value="<?php echo $today['mon']; ?>">
									  /
								      <input type="text" name="txtStartDay" size="4" value="<?php echo $today['mday']; ?>">
								      /
								      <input type="text" name="txtStartYear" size="8" value="<?php echo $today['year']; ?>"> 
							          <span class="style4">(mm/dd/yyyy) </span></td>
								</tr>
								<tr>
									<td><span class="basetext">End Date:</span></td>
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