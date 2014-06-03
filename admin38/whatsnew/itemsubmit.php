<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 01/17/05
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
    $itemID=$_POST['hdnItemID'];
    $startday=$_POST['txtStartDay'];
	$startmonth=$_POST['txtStartMonth'];
	$startyear=$_POST['txtStartYear'];
    $endday=$_POST['txtEndDay'];
	$endmonth=$_POST['txtEndMonth'];
	$endyear=$_POST['txtEndYear'];
    $txtItemName=$_POST['txtItemName'];
    $txtFileAddress=$_POST['txtFileAddress'];
    $txtCSSAddress=$_POST['txtCSSAddress'];
	$intItemFound=0;
  	include('../../includes/database.inc');
    $result = mysql_query ("SELECT * FROM spotlight_items WHERE item_name = '$txtItemName' AND stylesheet_loc='$txtCSSAddress' AND include_file_loc='$txtFileAddress' AND start_date='$startyear-$startmonth-$startday' AND end_date='$endyear-$endmonth-$endday'", $database);
	if ($result){
//		$intItemFound++;
	};

    mysql_close($database);
	if ($intItemFound==0){
    	if ($itemID=="AAA")
    	{
	      $querystring = "INSERT INTO spotlight_items (spotlight_item_id, item_name, stylesheet_loc, include_file_loc, start_date, end_date) VALUES ('', '$txtItemName', '$txtCSSAddress', '$txtFileAddress', '$startyear-$startmonth-$startday', '$endyear-$endmonth-$endday');";
	    } else {
	      $querystring = "UPDATE spotlight_items SET start_date = '$startyear-$startmonth-$startday', end_date = '$endyear-$endmonth-$endday', item_name='$txtItemName', stylesheet_loc='$txtCSSAddress', include_file_loc='$txtFileAddress' WHERE spotlight_item_ID='$itemID'";
	    };
		include ('../../includes/database.inc');
	    $result = mysql_query ($querystring, $database);
	};
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<title>Special Item Submission Screen</title>
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
						<span class="title">Spotlight Item Submission Screen</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top"><p class="title style1">Navigation:</p>
				  <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br>
                      <a href="menu.php">Back to What's New Menu</a></p></td>
				<td>
					<div align="center">
<?php
	echo $querystring . "\r";
	if ($intItemFound==0){
    	if ($itemID=="AAA")
    	{
?>						
						<p class="basetext">
                      The spotlight item has been successfully added into the database.</p>
	<?php } else { ?>
						<p class="basetext">The spotlight event has been successfully changed in the database.                         </p>
	<?php }; 
	} else {
	?>
						<p class="basetext">The spotlight item could not be added to the database.  A spotlight item with all of the same information has already been found in the database.  Either the event had been entered previously or you have refreshed this page (possibly by coming back to it after viewing a different page).</p>
	
	<?php }; ?>
						<span class="basetext">
						<p>To see the item on the home page, click <a href="../../index.php" target="_blank">here</a>. </p>
						<p> To get back to the main menu, click <a href="../menu.php">here</a>.</p>
						<p> To get back to the What's New menu, click <a href="menu.php">here</a>.</p>
				  </span></div>
				</td>
			</tr>
		</table>
		<p></p>
	</body>

</html>