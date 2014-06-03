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
		<meta name="generator" content="Adobe GoLive 6">
		<title>Ribbon Menu</title>
		<SCRIPT language="JavaScript1.1" type="text/javascript">
            function besure(){
            	return confirm("Do you really want to delete this ribbon?");
            };
        </script>
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
						<span class="title">Ribbon Menu</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top"><p class="title style1 style1">Navigation:</p>
				  <p class="basetext1"><a href="../menu.php">Back to Main Menu</a><br>
				      <a href="menu.php">Back to Parts Menu</a></p></td>
				<td>				  <div align="center">
						
							<table width="500" border="0" cellspacing="0" cellpadding="0">
								<TR>
									<TD>&nbsp;</TD>
								</TR>
								<tr>
								  <form action="addribbon.php" method="post" name="AddEvent">
									<td width="200"><span class="basetext">Add Ribbon </span></td>
									<td width="200"></td>
									<td width="100"><input type="submit" name="sbAdd" value="New Ribbon"></td>
								  </form>
								</tr>
								<TR>
									<TD>&nbsp;</TD>
								</TR>
								<tr>
								  <form action="editribbon.php" method="post" name="EditEvent">
									<td width="200"><span class="basetext">Edit Ribbon </span></td>
									<td width="200"><select name="txtRibbonID" size="1">
											<?php makerows(); ?>
										</select></td>
									<td width="100"><input type="submit" name="sbEdit" value="Edit Ribbon"></td>
								  </form>		
								</tr>
								<TR>
									<TD>&nbsp;</TD>
								</TR>
								<tr>
								  <form action="deleteribbon.php" method="post" name="DeleteEvent">					
  									<td width="200"><p class="basetext">Delete Ribbon </p>								    </td>
									<td width="200"><select name="txtRibbonID" size="1">
											<?php makerows(); ?>
										</select></td>
									<td width="100"><input type="submit" name="sbDelete" value="Delete Ribbon" onclick="return besure();"></td>
								  </form>		
								</tr>																<TR>
									<TD>&nbsp;</TD>
								</TR>
<tr>
								  <form action="../menu.php" method="post" name="ReturnToMain">					
  									<td width="200"><span class="basetext">Return to Main Menu </span></td>
									<td width="200">&nbsp;</td>
									<td width="100"><input type="submit" name="sbDelete" value="Return to Main"></td>
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