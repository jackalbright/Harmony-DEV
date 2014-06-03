<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 9/22/04
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
   $eventID=$_GET['txtEventID'];
	include ('../../includes/database.inc');
	$qString="SELECT *, YEAR(start_date) as startYear, MONTH(start_date) as startMonth, DAYOFMONTH(start_date) as startDay, YEAR(end_date) as endYear, MONTH(end_date) as endMonth, DAYOFMONTH(end_date) as endDay FROM `event` WHERE event_ID='$eventID'";
    $result = mysql_query ($qString, $database);
    while ($event = mysql_fetch_object($result))
        {
           $startdate['month']=$event->startMonth;
           $startdate['day']=$event->startDay;
           $startdate['year']=$event->startYear;
           $enddate['month']=$event->endMonth;
           $enddate['day']=$event->endDay;
           $enddate['year']=$event->endYear;
           $title=$event->intro_text;
           $maintext=$event->main_text;
           $txtURLAddress=$event->target_url;
           $graphicloc=$event->graphic_location;
         };
     mysql_close($database);
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
    function loadgraphic(){
		document.eventgraphic.src="../../" + document.FormName.txtGraphicLocation.value;
	};
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
	<body bgcolor="#ffffff" onLoad="loadgraphic();">
		<table width="700" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="top" width="200">
					<div align="center">
						<img src="../hdlogo.gif" alt="" height="78" width="160" border="0"></div>
				</td>
				<td valign="bottom">
					<div align="center">
						<span class="title">Event Editing Page</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top" class="title style1"><p class="style1">Navigation:</p>
				  <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br>
                      <a href="menu.php">Back to Event Menu</a></p>
				  <p>Graphic</p>
				  <p><img name="eventgraphic" src="../../stamps/blankstamp.gif"></p>
			    <p>&nbsp;</p>
			    </td>
				<td>
					<div align="center">
						<form action="eventsubmit.php" method="post" name="FormName" onSubmit="return validateForm();">
						<table width="450" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td><span class="basetext">Event Title:</span></td>
									<td><input type="text" name="txtIntroText" size="60"  value="<?php echo $title; ?>"></td>
								</tr>
								<tr>
									<td><span class="basetext">Event Description:</span></td>
									<td><textarea name="txtMainText" rows="6" cols="60"><?php echo stripslashes($maintext); ?></textarea></td>
								</tr>
								<tr>
									<td><span class="basetext">Target URL: </span><br>
								    <span class="style4">(Put in the address of the page you wish the event to point.) </span></td>
									<td><input type="text" name="txtURLAddress" value="<?php echo $txtURLAddress; ?>" size="60"></td>
								</tr>
								<tr>
									<td><span class="basetext">Graphic Location:</span></td>
									<td><input type="text" name="txtGraphicLocation" size="60" value="<?php echo $graphicloc; ?>"></td>
								</tr>
								<tr>
									<td><span class="basetext">Start Date:</span></td>
								  <td><input type="text" name="txtStartMonth" size="4" value="<?php echo $startdate['month']; ?>">
/
  <input type="text" name="txtStartDay" size="4" value="<?php echo $startdate['day']; ?>">
/
<input type="text" name="txtStartYear" size="8" value="<?php echo $startdate['year']; ?>">
<span class="style4">(mm/dd/yyyy)</span></td>
								</tr>
								<tr>
									<td><span class="basetext">End Date:</span></td>
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
											<input type="submit" name="sbSubmit" value="Submit" ><input type="reset" name="sbReset" value="Reset"></div>
									</td>
								</tr>
							</table>      <input type="hidden" name="hdnEventID" value="<?php echo $eventID; ?>">
							
						</form>
					</div>
				</td>
			</tr>
		</table>
		<p></p>
	</body>
</html>