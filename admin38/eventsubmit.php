<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 4/3/04
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
	if ($_SESSION['canManageEvents']=="No"){
		header ('Location: ../menu.php');
	};
?>
<?php
    $eventID=$_POST['hdnEventID'];
    $startday=$_POST['txtStartDay'];
	$startmonth=$_POST['txtStartMonth'];
	$startyear=$_POST['txtStartYear'];
    $endday=$_POST['txtEndDay'];
	$endmonth=$_POST['txtEndMonth'];
	$endyear=$_POST['txtEndYear'];
    $title=$_POST['txtIntroText'];
    $maintext=$_POST['txtMainText'];
    $searchterms=$_POST['txtSearchTerms'];
    $graphicloc=$_POST['txtGraphicLocation'];

    if ($eventID=="AAA")
    {
      $querystring = "INSERT INTO event ( event_ID, start_date, end_date, intro_text, main_text, search_terms, graphic_location) VALUES ('', '$startyear-$startmonth-$startday', '$endyear-$endmonth-$endday', '$title', '$maintext', '$searchterms', '$graphicloc');";
    } else {
      $querystring = "UPDATE event SET start_date = '$startyear-$startmonth-$startday', end_date = '$endyear-$endmonth-$endday', intro_text='$title', main_text= '$maintext', search_terms='$searchterms', graphic_location='$graphicloc' WHERE event_ID='$eventID'";
    };
	include ('../../includes/database.inc');
    $result = mysql_query ($querystring, $database);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<meta name="generator" content="Adobe GoLive 6">
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
						<span class="basetext">
                                   The following query has been sent to the database: 
                                   <p><?php echo $querystring ?></p>
                                   <p> To get back to the main menu, click <a href="../menu.php">here</a>.</p>
                                   <p> To get back to the Special Events menu, click <a href="menu.php">here</a>.</p>
</span></div>
				</td>
			</tr>
		</table>
		<p></p>
	</body>

</html>