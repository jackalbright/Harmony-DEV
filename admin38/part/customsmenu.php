<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 10/20/04
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
	if ($_SESSION['canManageParts']!="Yes"){
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
    $result = mysql_query ("SELECT ribbon_id, color_name FROM `ribbon` order by ribbon_id", $database);
    echo "<option value=\" \" selected>Select a ribbon color...</option>\n";
    while ($row = mysql_fetch_row($result))
        {
           $eventID=$row[0];
           $title=$row[1];
           echo "<option value=\"$eventID\">$eventID - $title</option>\n";
         };
     mysql_close($database);
  };
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<title>Custom Graphic Menu</title>
        <link href="../../stylesheets/style.css" rel="stylesheet" type="text/css">
	    <style type="text/css">
<!--
.style1 {font-size: medium}
-->
        </style>
	</head>

	<body bgcolor="#ffffff">
		<table width="750" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="top" width="200">
					<div align="center">
						<img src="../hdlogo.gif" alt="" height="78" width="160" border="0"></div>
				</td>
				<td valign="bottom">
					<div align="center">
						<span class="title">Custom Graphic Menu</span></div>
				</td>
			</tr>
			<tr>
			  <td width="200" valign="top"><p class="title style1 style1">Navigation:</p>
				  <p><a href="../menu.php">Back to Main Menu</a><br>
		      <a href="menu.php">Back to Parts Menu</a><br>
		      </p>
			  </td>
				<td>				  <div align="center">
						
							<table width="500" border="0" cellspacing="0" cellpadding="0">
								<TR>
									<TD>&nbsp;</TD>
								</TR>
								<tr>
								  <form action="approvecustom.php" method="post" name="ApproveCustom">
									<td width="272" class="basetext">Approve Images </td>
									<td width="128"><div align="right">
									  <input type="submit" name="sbAdd" value="Image Approval">
									  </div></td>
									<td width="100">&nbsp;</td>
								  </form>
								</tr>
								<TR>
									<TD>&nbsp;</TD>
								</TR>
								<tr>
								  <form action="editcustom.php" method="post" name="EditCustom">
									<td width="272"><span class="basetext">Upload Image for Customer<br>
								    (Not yet active) </span></td>
									<td width="128"><div align="right">
									  <input type="submit" name="sbEdit" value="Upload Image">
									  </div></td>
									<td width="100">&nbsp;</td>
								  </form>		
								</tr>

							</table>
					</div>
					<div align="left">
						<p></p>
					</div>
				</td>
			</tr>
		</table>
		<p></p>
	</body>

</html>