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
	if ($_SESSION['canManageEvents']!="Yes"){
		header ('Location: ../menu.php');
	};
?>
<?php
	include ('../../includes/admin.inc');
?>
<?php
  function makerows()
  {
	include ('../../includes/database.inc');
    $result = mysql_query ("SELECT * FROM `event` ORDER BY intro_text", $database);
    echo "<option value=\" \" selected>Select an event...</option>\n";
    while ($row = mysql_fetch_row($result))
        {
           $eventID=$row[0];
           $title=$row[3];
           echo "<option value=\"$eventID\">$title</option>\n";
         };
     mysql_close($database);
  };
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<meta name="generator" content="Adobe GoLive 6">
		<title>Event Menu</title>
	    <link href="../../stylesheets/style.css" rel="stylesheet" type="text/css">
		<script language="javascript1.2" type="text/javascript">
			function checkDelete(){
				return confirm("Do you really want to delete this event?");
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
						<span class="title">Special Event Menu</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top"><p class="title">Navigation:</p>
			    <p class="basetext1"><a href="../menu.php">Back to Main Menu</a></p></td>
				<td>
					<div align="left">
						<br>
						<ul>
						  <li><span class="basetext"><a href="itemmenu.php">Spotlight Items </a></span><br> 
					      Add and edit specials that are spotlighted on the home page, the newsletter, and the What's New page.<br>
					      <li><span class="basetext"><a href="featuremenu.php">Web Feature Announcements </a></span><br> 
					      Add text about new features that will appear in the What's New section on the home page and What's New page, plus in the newsletter.<br>
					      <li><span class="basetext"><a href="announcementmenu.php">General Announcements </a></span><br> 
					      Add text for announcements that will appear in the What's New section on the home page and What's New page, plus in the newsletter.<br>
					      <li><span class="basetext"><a href="newslettermenu.php">Newletters</a></span><br> 
					      Create and send the regular promotional newsletter for our customers. <br>
					      <br>
                            <br>						
                          </ul>
					</div>
				</td>
			</tr>
		</table>
		<p></p>
	</body>

</html>