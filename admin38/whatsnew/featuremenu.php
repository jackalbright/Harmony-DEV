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
    $result = mysql_query ("SELECT * FROM `web_feature` ORDER BY start_date", $database);
    echo "<option value=\" \" selected>Select a feature...</option>\n";
    while ($row = mysql_fetch_row($result))
        {
           $eventID=$row[0];
           $title=$row[1];
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
						<span class="title">Web Feature Menu</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top"><p class="title style1 style1">Navigation:</p>
			    <p class="basetext1"><a href="../menu.php">Back to Main Menu</a></p></td>
				<td>
					<div align="left">
						<br>
						<ul>
						  <li><span class="basetext"><a href="addfeature.php">Add Web Feature Announcement </a></span><br> 
					      Point out the new features that we have available on our website with an announcement in the What's New area on the home page. (This will require some HTML for linking to the page.) <br>
						  <li><span class="basetext">Edit Web Feature Announcements </span><br>
						    Edit the Announcements listed below. <br>
						    <form action="editfeature.php" method="get" name="EditItem">
						      <select name="txtFeatureID">
							  <?php makerows(); ?>
					          </select>
                              <input type="submit" name="sbEditItem" value="Edit Item">
					        </form></li>
						    <li><span class="basetext">Delete Web Feature Announcement </span><br>
						    Remove Web Feature Announcements from the database. Note: This will remove the feature from past issues of the newsletter as well. <br>
						    <form action="deleteitem.php" method="post" name="DeleteItem">
						      <select name="txtItemID">
							  <?php makerows(); ?>
					          </select>
                              <input type="submit" name="sbDeleteItem" value="Delete Item">
					        </form>
                            <br></LI>
                          </ul>
					</div>
				</td>
			</tr>
		</table>
		<p></p>
	</body>

</html>