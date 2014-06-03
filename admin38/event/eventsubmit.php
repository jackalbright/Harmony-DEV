<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 02/07/04
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
    $eventID=$_POST['hdnEventID'];
    $startday=$_POST['txtStartDay'];
	$startmonth=$_POST['txtStartMonth'];
	$startyear=$_POST['txtStartYear'];
    $endday=$_POST['txtEndDay'];
	$endmonth=$_POST['txtEndMonth'];
	$endyear=$_POST['txtEndYear'];
    $title=addslashes(htmlentities($_POST['txtIntroText']));
    $maintext=addslashes(htmlentities($_POST['txtMainText']));
    $txtURLAddress=$_POST['txtURLAddress'];
    $graphicloc=$_POST['txtGraphicLocation'];
	$intEventFound=0;
  	include ('../../includes/database.inc');
    $result = mysql_query ("SELECT * FROM event WHERE start_date = '$startyear-$startmonth-$startday' AND end_date = '$endyear-$endmonth-$endday' AND intro_text=\'$title\' AND main_text=\'$maintext\' AND target_url=\'$txtURLAddress\' AND graphic_location=\'$graphicloc\'", $database);
	if ($result){
		$intEventFound++;
	};
    mysql_close($database);
	if ($intEventFound==0){
    	if ($eventID=="AAA")
    	{
	      $querystring = "INSERT INTO event ( event_ID, start_date, end_date, intro_text, main_text, target_url, graphic_location) VALUES ('', '$startyear-$startmonth-$startday', '$endyear-$endmonth-$endday', '$title', '$maintext', '$txtURLAddress', '$graphicloc');";
	    } else {
	      $querystring = "UPDATE event SET start_date = '$startyear-$startmonth-$startday', end_date = '$endyear-$endmonth-$endday', intro_text='$title', main_text= '$maintext', target_url='$txtURLAddress', graphic_location='$graphicloc' WHERE event_ID='$eventID'";
	    };
		include ('../../includes/database.inc');
	    $result = mysql_query ($querystring, $database);
	};
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<title>Event Submission Screen</title>
		<style type="text/css" media="screen">
		<!--
.title { color: blue; font-style: normal; font-weight: bold; font-size: large; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.errormsg { color: red; font-style: normal; font-weight: bolder; font-size: small; line-height: normal; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetext { color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.style1 {font-size: medium}
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
					<div align="center">
						<span class="title">Event Submission Screen</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top"><p class="title style1">Navigation:</p>
				  <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br>
                      <a href="menu.php">Back to Event Menu</a></p></td>
				<td>
					<div align="center">
<?php
	echo "$querystring<BR>";
	if ($intEventFound==0){
    	if ($eventID=="AAA")
    	{
?>						
						<p class="basetext">
                      The event has been successfully added into the database.</p>
	<?php } else { ?>
						<p class="basetext">The event has been successfully changed in the database.                         </p>
	<?php }; 
	} else {
	?>
						<p class="basetext">The event could not be added to the database.  An event with all of the same information has already been found in the database.  Either the event had been entered previously or you have refreshed this page (possibly by coming back to it after viewing a different page).</p>
	
	<?php }; ?>
						<span class="basetext">
						<p>To see the event on the Special Events page, click <a href="../../recent-events.php" target="_blank">here</a>. </p>
						<p> To get back to the main menu, click <a href="../menu.php">here</a>.</p>
						<p> To get back to the Special Events menu, click <a href="menu.php">here</a>.</p>
				  </span></div>
				</td>
			</tr>
		</table>
		<p></p>
	</body>

</html>